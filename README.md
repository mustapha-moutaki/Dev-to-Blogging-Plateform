# Dev.to Content Management System (CMS)

Welcome to the **Dev.to Content Management System (CMS)**, a project designed and developed to provide a complete platform for developers and tech enthusiasts to share, explore, and collaborate on articles efficiently. This project combines a seamless user experience for front-office users and a powerful dashboard for administrators to manage content and users.

## 🚀 Features

### 🔒 Back Office (Administrator)

#### **Category Management**
- Create, modify, and delete categories.
- Associate multiple articles with a category.
- Visualize category statistics through dynamic charts.

#### **Tag Management**
- Create, modify, and delete tags.
- Associate tags with articles for precise searches.
- Visualize tag statistics using interactive graphics.

#### **User Management**
- View and manage user profiles.
- Assign permissions to users to promote them as authors.
- Suspend or delete users for violations.

#### **Article Management**
- Review, accept, or reject submitted articles.
- Archive inappropriate content.
- View statistics for the most-read articles.

#### **Dashboard and Analytics**
- Detailed overview of users, articles, categories, and tags.
- Top 3 authors based on the number of published or read articles.
- Interactive graphs for categories and tags.
- Insights into the most popular articles.

#### **Detail Pages**
- **Single Article Page**: Full details of an article.
- **User Profile Page**: View user profiles.

---

### 🌟 Front Office (User)

#### **Account Management**
- Secure registration with name, email, and password.
- Role-based redirection (admin to dashboard, users to home).

#### **Navigation and Search**
- Interactive search bar for articles, categories, and tags.
- Dynamic navigation for browsing articles and categories.

#### **Content Display**
- Show latest articles and categories on the homepage or dedicated sections.
- Redirect to detailed article pages with full content, associated categories, tags, and author info.

#### **Author Space**
- Create, edit, and delete articles.
- Assign one category and multiple tags to articles.
- Manage published articles from a personal dashboard.

---

## 🛠️ Technologies Used

- **PHP 8**: Object-Oriented Programming.
- **Database**: PDO for secure database interactions.

---

## 🎯 Project Structure

- **Clear Separation of Logic**: Business logic and architecture are decoupled for maintainability.
- **Responsive Design**: Fully optimized for all screen sizes using modern CSS frameworks.
- **Security First**: 
  - Prepared and parameterized queries to prevent SQL Injection.
  - Input validation and escaping to avoid XSS (Cross-Site Scripting).
  - Backend CSRF protection for secure forms.

---

## 📋 Validation and Performance

- **Frontend Validation**: HTML5 and native JavaScript to minimize user errors.
- **Backend Validation**: Handles edge cases and prevents malicious inputs (e.g., XSS and CSRF).

- **Daily Commits**: All changes are committed daily to GitHub for better traceability and collaboration.
- **Task Management**: User stories and tasks planned with Jira.

---

## 📊 Performance Criteria

- **Responsive Design**: Adaptive for all device types.
- **Validation**: Robust client-side and server-side validation.
- **Interactive Analytics**: Charts and graphs for data visualization.

---

## 💻 Installation and Setup

1. Clone this repository:
   ```bash
   git clone https://github.com/mustapha-moutaki/Dev-to-Blogging-Plateform.git

-composer install


## 🛡️ Security

### Preventing SQL Injection
- Using **prepared statements** and **parameterized queries** for all database interactions to ensure secure handling of user inputs and prevent malicious queries.

### Preventing XSS (Cross-Site Scripting)
- Escaping all user-provided data before rendering it in HTML templates to avoid injecting and executing malicious scripts in the browser.


