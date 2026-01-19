# Task Management App

## Overview
A professional web application for efficient task and subtask management, featuring a robust admin panel. Built with HTML, CSS, JavaScript (AJAX/JSON), and PHP (MySQL), this app supports individual and team productivity with modern UI/UX and secure, role-based access.

## Features
- **User Features:**
  - Task creation, editing, and deletion
  - Subtask management (add, edit, delete, mark as done)
  - File attachments for tasks
  - Progress tracking and dashboard
  - Activity history and search/filter
  - Profile management
- **Admin Features:**
  - Admin dashboard with user and task management
  - Change user roles (User/Admin)
  - Delete users and tasks
  - View activity logs
  - Secure, role-based access control
- **General:**
  - Responsive, modern UI
  - Client-side and server-side validation
  - Secure session and input handling

## Technologies Used
- **Frontend:**
  - HTML5, CSS3 (custom, responsive)
  - JavaScript (ES6+), AJAX, JSON
- **Backend:**
  - PHP 7/8
  - MySQL/MariaDB


## Usage
- **Register/Login:** Create an account or log in.
- **Task Management:** Add, edit, delete tasks and subtasks. Attach files as needed.
- **Admin Panel:** (Admins only) Access via `view/php/adminPanel.php` for user/task management and logs.
- **Profile:** Update your profile and avatar.

## Project Structure
```
Task Management App/
├── asset/
│   ├── css/         # Stylesheets
│   ├── js/          # JavaScript files
│   ├── database/    # SQL files
│   ├── imgs/        # Images/icons
│   └── upload/      # Uploaded files (profile pics, task files)
├── controller/      # PHP controllers (business logic, AJAX endpoints)
├── model/           # PHP models (database interaction)
├── view/
│   ├── html/        # Static HTML pages
│   └── php/         # Dynamic PHP views
├── index.php
├── README.md
└── LICENSE
```



## License
This project is licensed under the GNU General Public License v3.0. See the [LICENSE](LICENSE) file for details.