<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت کاربران</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Global Styles & Font */
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: #4a90e2;
            --primary-hover-color: #357ABD;
            --background-color: #f4f7fc;
            --panel-background: #ffffff;
            --text-color: #333;
            --text-secondary-color: #777;
            --border-color: #e0e0e0;
            --danger-color: #f44336;
            --success-color: #28a745;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Main Dashboard Container */
        .dashboard {
            display: flex;
            width: 100%;
            max-width: 1300px;
            /* A bit wider to accommodate more content */
            height: 85vh;
            min-height: 700px;
            background-color: var(--panel-background);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* User List Panel (Right) - No major changes here */
        .user-panel {
            flex-basis: 35%;
            border-left: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        .user-panel-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .create-user-btn {
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            font-family: 'Vazirmatn', sans-serif;
            font-weight: 500;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .create-user-btn:hover {
            background-color: var(--primary-hover-color);
        }

        .create-user-btn i {
            margin-left: 8px;
        }

        .search-bar {
            padding: 1rem 1.5rem;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 14px;
        }

        .user-list {
            list-style: none;
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Custom Scrollbar */
        .user-list::-webkit-scrollbar,
        .profile-panel::-webkit-scrollbar {
            width: 6px;
        }

        .user-list::-webkit-scrollbar-thumb,
        .profile-panel::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .user-list::-webkit-scrollbar-thumb:hover,
        .profile-panel::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        .user-list-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .user-list-item:hover {
            background-color: #f9f9f9;
        }

        .user-list-item.active {
            background-color: var(--primary-color);
            color: white;
        }

        .user-list-item.active .user-email {
            color: #e0e0e0;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 15px;
        }

        .user-name {
            font-weight: 500;
        }

        .user-email {
            font-size: 14px;
            color: var(--text-secondary-color);
            transition: color 0.2s ease;
        }

        /* ====== Profile Panel (Left) - ENHANCED ====== */
        .profile-panel {
            flex-basis: 65%;
            padding: 2.5rem 3rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            /* Make it scrollable */
        }

        .profile-placeholder {
            text-align: center;
            color: var(--text-secondary-color);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .profile-placeholder i {
            font-size: 50px;
            margin-bottom: 1rem;
        }

        .profile-view {
            display: none;
            /* Hidden by default */
            width: 100%;
        }

        /* User Header Section */
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 3rem;
        }

        .profile-picture-container {
            position: relative;
            width: 100px;
            height: 100px;
            margin-left: 2rem;
            flex-shrink: 0;
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .picture-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-picture-container:hover .picture-overlay {
            opacity: 1;
        }

        .picture-overlay i {
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin: 0 8px;
            transition: transform 0.2s ease;
        }

        .picture-overlay i:hover {
            transform: scale(1.2);
        }

        .profile-details h2 {
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
        }

        .profile-details p {
            font-size: 1rem;
            color: var(--text-secondary-color);
        }

        /* Form Sections for editing */
        .form-section {
            margin-bottom: 2.5rem;
        }

        .form-section h3 {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.75rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-group:last-child {
            margin-bottom: 0;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: var(--text-secondary-color);
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px 14px 45px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        /* File Upload Zone */
        .file-drop-zone {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .file-drop-zone.dragover {
            border-color: var(--primary-color);
            background-color: #f9fcff;
        }

        .file-drop-zone .icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .file-drop-zone p {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .file-drop-zone span {
            font-size: 0.9rem;
            color: var(--text-secondary-color);
        }

        /*input[type="file"] {
            display: none;
        }

        */

        /* Existing Files List */
        .file-list ul {
            list-style: none;
            margin-top: 1.5rem;
        }

        .file-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background-color: #f9fafb;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .file-info {
            display: flex;
            align-items: center;
        }

        .file-info i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-left: 1rem;
        }

        .file-actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 1rem;
            color: var(--text-secondary-color);
            transition: color 0.3s;
        }

        .file-actions button:hover {
            color: var(--primary-color);
        }

        .file-actions .delete-btn:hover {
            color: var(--danger-color);
        }

        .profile-footer {
            margin-top: auto;
            /* Pushes the button to the bottom if content is short */
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .save-btn {
            background-color: var(--success-color) !important;
        }

        .save-btn:hover {
            background-color: #218838 !important;
        }

        /* Responsive */
        @media (max-width: 992px) {
            body {
                padding: 0;
                align-items: flex-start;
            }

            .dashboard {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                border-radius: 0;
            }

            .user-panel {
                flex-basis: auto;
                border-left: none;
                border-bottom: 1px solid var(--border-color);
            }

            .profile-panel {
                flex-basis: auto;
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="dashboard">

        <!-- User Selection Panel (Right) -->
        <div class="user-panel">
            <div class="user-panel-header">
                <button class="create-user-btn" data-href="{{ route('user.create') }}"><i
                        class="fa-solid fa-plus"></i>ساخت کاربر جدید</button>
            </div>
            <div class="search-bar">
                <input id="search" type="search" name="search" data-url="{{ route('user.search') }}" placeholder="جستجوی کاربر...">
                <span id="search-info"></span>
            </div>
            {{ $users->links('vendor.pagination.simple-default') }}
            <ul class="user-list" data-info-user="{{ route('profile.user') }}">
                <!-- User items will be dynamically handled but kept for initial view -->
                @foreach ($users as $user)
                    <li data-id="{{ $user->id }}" class="user-list-item" data-id="user1">
                        <img src="{{ asset('user-icon.jpg') }}" alt="Avatar" data-id="{{ $user->id }}"
                            class="user-avatar">
                        <div class="user-info">
                            <div data-id="{{ $user->id }}" class="user-name">{{ $user->name }}</div>
                            <div data-id="{{ $user->id }}" class="user-email">{{ $user->username }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Enhanced Profile & Edit Panel (Left) -->
        <div class="profile-panel">
            <div class="profile-placeholder">
                <i class="fa-regular fa-hand-pointer"></i>
                <p>برای نمایش جزئیات، یک کاربر را از لیست انتخاب کنید</p>
            </div>

            <div class="profile-view">
                <header class="profile-header">
                    <div class="profile-picture-container">
                        <img src="{{ asset('user-icon.jpg') }}" alt="Profile Picture" class="profile-picture"
                            id="profile-img">
                        <div class="picture-overlay">
                            <i class="fa-solid fa-camera" title="تغییر عکس"></i>
                            <i class="fa-solid fa-trash-can" title="حذف عکس"></i>
                        </div>
                    </div>
                    <div class="profile-details">
                        <h2 id="profile-name"></h2>
                        <p id="profile-email"></p>
                    </div>
                    <a style="text-decoration:none;color:#4A90E2;" href="{{ route('document.list') }}" id="listDocumentUser">
                        رفتن به لیست فایل های ارسالی برای کاربر
                    </a>
                </header>

                <div class="form-section">
                    <h3>تغییر رمز عبور</h3>
                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="text" name="password" data-url="{{ route('user.update.password') }}" placeholder="رمز عبور جدید">
                        <span id="password-info"></span>
                    </div>
                </div>
                <span id="formInfo"></span>
                <form id="send-document" method="POST" enctype="multipart/form-data"
                    action="{{ route('user.document.send') }}">
                    <input type="hidden" value="" name="user_id" />
                    @csrf
                    <!-- Section: Change Password -->

                    <div class="form-section">
                        <h3>نام فایل</h3>
                        <div class="input-group">
                            <i class="fa-solid fa-pen"></i>
                            <input type="text" name="file_name" required placeholder="نام فایل را وارد کنید">
                        </div>
                    </div>

                    <!-- Section: File Management -->
                    <div class="form-section">
                        <h3>مدیریت فایل‌ها</h3>
                        <input type="file" name="file" id="file-upload">
                    </div>

                    <footer class="profile-footer">
                        <button type="submit" class="create-user-btn save-btn">
                            <i class="fa-solid fa-check"></i> ذخیره تغییرات
                        </button>
                    </footer>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('ajax.js') }}"></script>
</body>
</html>
