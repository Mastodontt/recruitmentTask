# **To-Do List Application**

This is a Laravel-based To-Do List application that allows users to manage tasks with features like CRUD operations, email notifications, task filtering, user authentication, and optional advanced functionalities like Google Calendar integration, and task sharing via public links.

---

## **Implemented Features**

### **Functional Requirements**
1. **CRUD Operations**: Manage tasks with fields like:
   - Name
   - Description
   - Priority
   - Status
   - Due Date
2. **Task Filtering**: Filter tasks by priority, status, or due date.
3. **Email Notifications**: Send email reminders 1 day before the task's due date.
4. **Validation**: Ensure all inputs are validated correctly.
5. **User Authentication**: Users can log in and manage their tasks individually.

### **Implemented Optional Features**
- Share tasks publicly via expirable access tokens.
- Integration with Google Calendar for task scheduling.
---

## **Prerequisites**

Before running this application, ensure you have the following installed:
- **Docker**: [Install Docker](https://docs.docker.com/get-docker/)
- **Laravel Sail**: Installed along with the project.

---

## **Setup Instructions**

### **1. Clone the Repository**
git clone <repository-url>
cd <repository-folder>

### **2. Copy env**
cp .env.example .env

### **3. Install Dependencies**
composer install
npm install

### **4. Start Laravel Sail**
./vendor/bin/sail up -d

### **5. Generate the Application Key**
./vendor/bin/sail artisan key:generate

### **6. Run migrations**
./vendor/bin/sail artisan migrate

### **7. Run npm dev**
./vendor/bin/sail npm dev

### **8. Access the Application**
http://localhost

### **9. To run automated tests**
./vendor/bin/sail artisan test

### **10. Google Calendar Integration**

Place your Google Calendar JSON credentials in storage/app/google-calendar/.
Update the .env file