<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کاربر</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Global Styles & Font (Consistent with other pages) */
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: #4a90e2;
            --secondary-color: #50e3c2;
            --background-color: #f4f7fc;
            --panel-background: #ffffff;
            --text-color: #333;
            --text-secondary-color: #777;
            --border-color: #eaf0f6;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --pdf-color: #e74c3c;
            --image-color: #3498db;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Main Dashboard Container */
        .user-dashboard {
            width: 100%;
            max-width: 1100px;
            background-color: var(--panel-background);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            padding: 2.5rem;
        }

        /* Header Section */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .welcome-message h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .welcome-message p {
            color: var(--text-secondary-color);
            font-size: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info .username {
            margin-left: 1rem;
        }

        .user-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .logout-btn {
            background: none;
            border: 1px solid #ff4d4d;
            color: #ff4d4d;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Vazirmatn', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 2rem;
        }
        
        .dashboard-btn {
            width: 70px;
            text-align:center; 
            padding: 5px 0;
            text-decoration: none;
            border: 1px solid blue;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #ff4d4d;
            color: white;
        }

        /* File List Container */
        .file-list-container h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .file-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        .file-table th,
        .file-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .file-table thead {
            background-color: #f9fafb;
        }

        .file-table th {
            font-weight: 500;
            color: var(--text-secondary-color);
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .file-icon {
            font-size: 1.8rem;
            vertical-align: middle;
        }

        .file-icon.pdf {
            color: var(--pdf-color);
        }

        .file-icon.image {
            color: var(--image-color);
        }

        .file-name {
            font-weight: 500;
        }

        /* Action Buttons */
        .actions a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            margin: 0 4px;
            font-size: 0.9rem;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .actions a:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }

        .actions .download-btn {
            background-color: var(--primary-color);
        }

        .actions .print-btn {
            background-color: #2ecc71;
        }

        .actions i {
            margin-left: 6px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .user-dashboard {
                padding: 1.5rem;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-info {
                margin-top: 1rem;
            }

            .file-table thead {
                display: none;
            }

            .file-table tr {
                display: block;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                margin-bottom: 1rem;
                padding: 1rem;
            }

            .file-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.8rem 0;
                border: none;
            }

            .file-table td::before {
                content: attr(data-label);
                font-weight: 500;
                color: var(--text-secondary-color);
            }

            .file-table td.actions {
                justify-content: center;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    @empty ($user)
        @php($user = auth()->user()->load('documents'))
    @endempty

    <div class="user-dashboard">
        <header class="dashboard-header">
            <div class="welcome-message">
                <h1>سلام، {{ $user->name }}!</h1>
                <p>فایل‌هایی که تاکنون از طرف مدیریت دریافت کرده‌اید:</p>
            </div>
            <div class="user-info">
                @can('isAdmin')
                    <a class="dashboard-btn" @style([
                        'color:red;border-color:red' => !$isAdmin,
                        'color:green;border-color:green' => $isAdmin,
                    ]) href="{{ route('user.toggle.role', $user) }}">ادمین</a>
                    &nbsp;
                    <a class="dashboard-btn" href="{{ route('dashboard') }}">پنل</a>
                @endcan

                <form action="{{ route('logout') }}" method="POST" accept-charset="utf-8">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> خروج</button>
                </form>

                <span class="username">{{ $user->username }}</span>
                <img src="{{ asset('user-icon.jpg') }}" alt="User Avatar">
            </div>
        </header>

        <main class="file-list-container">
            <h2>صندوق ورودی شما</h2>
            <table class="file-table">
                <thead>
                    <tr>
                        <th>نوع</th>
                        <th>نام فایل</th>
                        <th>تاریخ ارسال</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="buttons">
                    @foreach ($user->documents as $document)
                        <tr>
                            <td data-label="نوع"><i
                                    class="fas file-icon {{ $document->file_type === 'file' ? 'image fa-file-image' : 'pdf fa-file-pdf' }}"></i>
                            </td>
                            <td data-label="نام فایل" class="file-name">{{ $document->file_name }}</td>
                            <td data-label="تاریخ ارسال">{{ jdate($document->file_date_upload)->format('%d %B %Y') }}</td>
                            <td data-label="عملیات" class="actions">
                                <a href="{{ route('document.download', $document->id) }}" class="download-btn">
                                    <i class="fas fa-download"></i>
                                    دانلود</a>
                                <a href="#"
                                    data-url="
                                      @if ($document->file_type !== 'pdf') {{ route('document.show', $document->id) }}
                                      @else
                                          {{ '/storage/' . $document->file }} @endif
                                      "
                                    class="print-btn"><i class="fas fa-print"></i> پرینت</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </div>
    <script>
        const buttons = document.getElementById('buttons');
        const logoutBtn = document.getElementById('logout-btn');

        buttons.addEventListener('click', function(e) {
            if (e.target.classList.contains('print-btn')) {
                const fileUrl = e.target.dataset.url;

                const win = window.open(fileUrl, '_blank');
                win.focus();
                win.onload = () => {
                    win.print();
                };
            }
        })
    </script>
</body>
</html>
