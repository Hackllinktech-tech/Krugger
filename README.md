# 🔐 PHP Authentication System

This repository contains a **secure** user authentication system built with **PHP** and **MySQL**. It includes essential features such as **user registration, login, logout, and session management**.

![Banner](src/images/banner.png)

---
## 📌 Features
✅ **User Registration** – Create an account with secure password hashing.  
✅ **User Login** – Authenticate users with session management.  
✅ **User Logout** – Secure logout with session destruction.  
✅ **Session Management** – Keep users logged in securely.  
✅ **Hashed Passwords** – Uses `password_hash()` for better security.  
✅ **Error Handling** – Displays friendly error messages.  

---
## 🎯 Usage

### 📝 User Registration
1. Navigate to **Signup Page** (`signup/`).
2. Fill out the registration form.
3. Submit the form.
4. Upon successful registration, you will be redirected to the login page.

![Signup](src/images/signup.png)

### 🔑 User Login
1. Go to the **Login Page** (`login/`).
2. Enter your credentials.
3. Click **Login** to access the dashboard.

![Login](src/images/login.png)
- **🖥 Admin Login:** `iqbolshoh`  
- **👤 User Login:** `user`  
- **🔑 Password:** `IQBOLSHOH`  

### 🔓 User Logout
1. Click the **Logout** button.
2. Your session will be destroyed, and you'll be redirected to the login page.

---
## 🚀 Installation

Follow these steps to set up the project locally:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/iqbolshoh/php-auth-system.git
   ```
2. **Navigate to the project directory:**
   ```bash
   cd php-auth-system
   ```
3. **Import the database:**
   - Open **phpMyAdmin** or any MySQL management tool.
   - Create a new database (`auth_system`).
   - Import the `database.sql` file.

4. **Update database credentials in `config.php`:**
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "auth_system";
   ```

---

## 🖥 Technologies Used
<div style="display: flex; flex-wrap: wrap; gap: 5px;">
    <img src="https://img.shields.io/badge/HTML-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white" alt="HTML">
    <img src="https://img.shields.io/badge/CSS-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white" alt="CSS">
    <img src="https://img.shields.io/badge/Bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
    <img src="https://img.shields.io/badge/JavaScript-%23F7DF1C.svg?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
    <img src="https://img.shields.io/badge/jQuery-%230e76a8.svg?style=for-the-badge&logo=jquery&logoColor=white" alt="jQuery">
    <img src="https://img.shields.io/badge/PHP-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</div>

---

## 🤝 Contributing  

🎯 Contributions are welcome! If you have suggestions or want to enhance the project, feel free to fork the repository and submit a pull request.

## 📬 Connect with Me  

💬 I love meeting new people and discussing tech, business, and creative ideas. Let’s connect! You can reach me on these platforms:

<div align="center">
    <table>
        <tr>
            <td>
                <a href="https://github.com/iqbolshoh">
                    <img src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/github.svg"
                        height="40" width="40" alt="GitHub" />
                </a>
            </td>
            <td>
                <a href="https://t.me/iqbolshoh_777">
                    <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/telegram.svg"
                        height="40" width="40" alt="Telegram" />
                </a>
            </td>
            <td>
                <a href="https://www.linkedin.com/in/iiqbolshoh/">
                    <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/linkedin.svg"
                        height="40" width="40" alt="LinkedIn" />
                </a>
            </td>
            <td>
                <a href="https://instagram.com/iqbolshoh_777" target="blank">
                    <img src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/instagram.svg"
                        alt="Instagram" height="40" width="40" />
                </a>
            </td>
            <td>
                <a href="https://wa.me/qr/22PVFQSMQQX4F1">
                    <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/whatsapp.svg"
                        height="40" width="40" alt="WhatsApp" />
                </a>
            </td>
            <td>
                <a href="https://x.com/iqbolshoh_777">
                    <img src="https://img.shields.io/badge/X-000000?style=for-the-badge&logo=x&logoColor=white" height="40"
                        width="40" alt="Twitter" />
                </a>
            </td>
            <td>
                <a href="mailto:iilhomjonov777@gmail.com">
                    <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/gmail.svg"
                        height="40" width="40" alt="Email" />
                </a>
            </td>
        </tr>
    </table>
</div>
