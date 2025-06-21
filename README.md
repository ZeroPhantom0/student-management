# Student Management System

## System Description
A comprehensive web application for educational institutions to manage student records, course enrollments, and file storage with secure authentication and API access.

## Key Features
- 🔐 Secure user authentication system
- 👨‍💼👩‍💼 Role-based access (Admin/Staff)
- 🧑‍🎓 Student profile management
- 📖 Course catalog system
- 📝 Enrollment and grading system
- 📁 Secure document management
- 📊 Analytics dashboard
- 📱 Mobile-responsive interface
- 🔌 REST API for integration

## Technology Stack
| Component          | Technology Used          |
|--------------------|--------------------------|
| Backend Framework  | CodeIgniter 4 (PHP)      |
| Database           | MySQL                    |
| Frontend           | Bootstrap 5, jQuery      |
| API Authentication | JWT Tokens               |
| Local Development  | XAMPP                    |
| Production Hosting | InfinityFree             |
| Version Control    | Git/GitHub               |

## Installation Guide

### 🖥️ Local Setup (XAMPP)
```bash
# Clone repository
git clone https://github.com/ZeroPhantom0/student-management.git
cd student-management

# Install dependencies
composer install

# Database setup
mysql -u root -p -e "CREATE DATABASE student_management"

# Configure environment
cp env .env
nano .env  # Edit with your credentials

# Required .env settings:

app.baseURL = 'http://localhost/student-management/public/'
database.default.hostname = localhost
database.default.database = student_management
database.default.username = root
database.default.password = your_password

# ☁️ Production Deployment (InfinityFree)
Upload all files EXCEPT public folder
Move public contents to htdocs
Update paths in htdocs/index.php:

$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');

#Configure .env:
app.baseURL = 'https://student-management3.infinityfreeapp.com/'
database.default.hostname = sql100.infinityfree.com
database.default.database = if0_39057704_student_management
database.default.username = if0_39057704
database.default.password = wGEMhMCZKVD

# 🔑 Default Login Credentials

Role	Email	            Password
Admin	admin@example.com	admin123
Staff	zen@gmail.com	    ako12345

# 🌐 Live Deployment

Access the live system at:
https://student-management3.infinityfreeapp.com
```

### Technology Used

- PHP with CodeIgniter – Used to build the system’s main features and structure.
- MySQL – Stores all data like students, courses, and user info.
- Bootstrap – Helps design a clean and responsive user interface.
- Git and GitHub – were used for version control and team collaboration
- Hosting Platforms – XAMPP for local testing, InfinityFree for online deployment.
