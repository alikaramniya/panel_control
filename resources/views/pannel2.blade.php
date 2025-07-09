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
            max-width: 1200px;
            height: 80vh;
            min-height: 600px;
            background-color: var(--panel-background);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* User List Panel (Right) */
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
        .user-list::-webkit-scrollbar {
            width: 6px;
        }
        .user-list::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }
        .user-list::-webkit-scrollbar-thumb:hover {
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

        /* Profile Panel (Left) */
        .profile-panel {
            flex-basis: 65%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            display: none; /* Hidden by default */
            width: 100%;
            text-align: center;
        }
        
        .profile-picture-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .picture-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right:0;
            bottom:0;
            width: 100%;
            height: 100%;
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
            font-size: 24px;
            cursor: pointer;
            margin: 0 10px;
            transition: transform 0.2s ease;
        }
        .picture-overlay i:hover {
            transform: scale(1.2);
        }
        
        .profile-details h2 {
            margin-bottom: 0.5rem;
        }
        .profile-details p {
            color: var(--text-secondary-color);
            margin-bottom: 2rem;
        }

        /* Responsive Design */
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

        <div class="user-panel">
            <div class="user-panel-header">
                <button class="create-user-btn">
                    <i class="fa-solid fa-plus"></i>
                    ساخت کاربر جدید
                </button>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="جستجوی کاربر...">
            </div>
            <ul class="user-list">
                <li class="user-list-item active" data-name="علی رضایی" data-email="ali.rezaei@example.com" data-img="https://i.pravatar.cc/150?img=68">
                    <img src="https://i.pravatar.cc/150?img=68" alt="Avatar" class="user-avatar">
                    <div class="user-info">
<div class="user-name">علی رضایی</div>
                        <div class="user-email">ali.rezaei@example.com</div>
                    </div>
                </li>
                <li class="user-list-item" data-name="سارا محمدی" data-email="sara.mohammadi@example.com" data-img="https://i.pravatar.cc/150?img=47">
                    <img src="https://i.pravatar.cc/150?img=47" alt="Avatar" class="user-avatar">
                    <div class="user-info">
                        <div class="user-name">سارا محمدی</div>
                        <div class="user-email">sara.mohammadi@example.com</div>
                    </div>
                </li>
                <li class="user-list-item" data-name="نیما احمدی" data-email="nima.ahmadi@example.com" data-img="">
                    <img src="https://i.pravatar.cc/150?u=nima" alt="Avatar" class="user-avatar">
                    <div class="user-info">
                        <div class="user-name">نیما احمدی (بدون عکس)</div>
                        <div class="user-email">nima.ahmadi@example.com</div>
                    </div>
                </li>
                 <li class="user-list-item" data-name="مریم حسینی" data-email="maryam.hoseini@example.com" data-img="https://i.pravatar.cc/150?img=32">
                    <img src="https://i.pravatar.cc/150?img=32" alt="Avatar" class="user-avatar">
                    <div class="user-info">
                        <div class="user-name">مریم حسینی</div>
                        <div class="user-email">maryam.hoseini@example.com</div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="profile-panel">
            
            {{-- <div class="profile-placeholder"> --}}
            {{--     <i class="fa-regular fa-hand-pointer"></i> --}}
            {{--     <p>برای نمایش و ویرایش جزئیات، یک کاربر را از لیست انتخاب کنید.</p> --}}
            {{-- </div> --}}
            <div class="profile-view">
                <header class="profile-header">
                    <div class="profile-picture-container">
                        <img src="" alt="Profile Picture" class="profile-picture" id="profile-img">
                        <div class="picture-overlay">
                            <i class="fa-solid fa-camera" title="تغییر عکس"></i>
                            <i class="fa-solid fa-trash-can" title="حذف عکس"></i>
                        </div>
                    </div>
                    <div class="profile-details">
                        <h2 id="profile-name"></h2>
                        <p id="profile-email"></p>
                    </div>
                </header>

                <form>
                    <!-- Section: Change Password -->
                    <div class="form-section">
                        <h3>تغییر رمز عبور</h3>
                        <div class="input-group">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" placeholder="رمز عبور جدید">
                        </div>
                    </div>

                    <!-- Section: File Management -->
                    <div class="form-section">
                        <h3>مدیریت فایل‌ها</h3>
                        <label for="file-upload" class="file-drop-zone">
                            <div class="icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                            <p>فایل جدید را اینجا بکشید یا برای انتخاب کلیک کنید</p>
                            <span>فرمت‌های مجاز: JPG, PNG, PDF</span>
                        </label>
                        <input type="file" id="file-upload" multiple>

                        <div class="file-list">
                            <ul id="user-files-list">
                                <!-- User files will be dynamically inserted here -->
                            </ul>
                        </div>
                    </div>

                    <footer class="profile-footer">
                        <button type="submit" class="create-user-btn save-btn">
                            <i class="fa-solid fa-check"></i> ذخیره تغییرات
                        </button>
                    </footer>
                </form>
            </div>
            {{-- <div class="profile-placeholder"> --}}
            {{--     <i class="fa-regular fa-hand-pointer"></i> --}}
            {{--     <p>برای نمایش جزئیات، یک کاربر را از لیست انتخاب کنید</p> --}}
            {{-- </div> --}}

            {{-- <div class="profile-view"> --}}
            {{--     <div class="profile-picture-container"> --}}
            {{--         <img src="https://i.pravatar.cc/150?img=68" alt="Profile Picture" class="profile-picture" id="profile-img"> --}}
            {{--         <div class="picture-overlay"> --}}
            {{--             <i class="fa-solid fa-camera" title="ارسال/ویرایش عکس"></i> --}}
            {{--             <i class="fa-solid fa-trash-can" title="حذف عکس"></i> --}}
            {{--         </div> --}}
            {{--     </div> --}}
            {{--     <div class="profile-details"> --}}
            {{--         <h2 id="profile-name">علی رضایی</h2> --}}
            {{--         <p id="profile-email">ali.rezaei@example.com</p> --}}
            {{--         <button class="create-user-btn" style="background-color: #28a745;">ذخیره تغییرات</button> --}}
            {{--     </div> --}}
            {{-- </div> --}}

        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userListItems = document.querySelectorAll('.user-list-item');
        const profileView = document.querySelector('.profile-view');
        const profilePlaceholder = document.querySelector('.profile-placeholder');
        
        // Profile elements to update
        const profileImg = document.getElementById('profile-img');
        const profileName = document.getElementById('profile-name');
        const profileEmail = document.getElementById('profile-email');

        // Initially hide placeholder and show the first user's data
        function showInitialUser() {
            const firstUser = document.querySelector('.user-list-item.active');
            if (firstUser) {
                updateProfileView(firstUser);
                profilePlaceholder.style.display = 'none';
                profileView.style.display = 'block';
            }
        }
        
        function updateProfileView(userItem) {
            const name = userItem.dataset.name;
            const email = userItem.dataset.email;
            let imgSrc = userItem.dataset.img;
// Use a default avatar if image source is empty
            if (!imgSrc) {
                // Creates a default avatar image based on name
                imgSrc = https://i.pravatar.cc/150?u=${name};
            }

            profileName.textContent = name;
            profileEmail.textContent = email;
            profileImg.src = imgSrc;
        }


        userListItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove .active from all other items
                userListItems.forEach(i => i.classList.remove('active'));
                
                // Add .active to the clicked item
                this.classList.add('active');
                
                // Update the profile view with data from the clicked item
                updateProfileView(this);

                // Show profile view and hide placeholder
                profilePlaceholder.style.display = 'none';
                //profileView.style.display = 'block';
            });
        });
        
        // Load the first user on page load
        showInitialUser();
    });
</script>

</body>
</html>
