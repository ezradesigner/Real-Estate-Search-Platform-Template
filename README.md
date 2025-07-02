# 🏠 Real Estate Search Platform  

A VivaReal-inspired property listing system with admin dashboard and advanced search functionality, developed as an academic project.

## ✨ Features  

- 🔍 Property search with filters (type, price, location)  
- 📱 Responsive UI with Tailwind CSS  
- ⚡ Instant search using Fuse.js  
- 🔐 Complete admin dashboard  
- ✉️ Email contact system  

## 🛠️ Tech Stack  

**Frontend:**  
- HTML5 + CSS3  
- Tailwind CSS  
- jQuery  
- Fuse.js (fuzzy search)  

**Backend:**  
- PHP  
- MySQL  

## 📂 Project Structure  

```
public_html/
├── index.html                 (Main homepage)
├── config.php                 (Database configuration)
├── database.sql               (Database schema)
├── admin/
│   ├── index.php              (Admin dashboard)
│   ├── login.php              (Admin login)
│   └── auth.php               (Authentication)
├── api/
│   └── imoveis.php           (Properties API)
├── css/
│   └── style.css             (Custom CSS)
└── js/
    └── app.js                (Custom JavaScript)
```

## 🚀 Setup Instructions  

1. Clone repository:
```bash
git clone [your-repo-url]
```

2. Import database:
```bash
mysql -u [username] -p [database_name] < database.sql
```

3. Configure:
- Update `config.php` with your DB credentials
- Set up SMTP in PHP mail() function

## 📝 License  

MIT License - See [LICENSE](LICENSE) file.

> **Note:** Academic project developed for educational purposes. Not for commercial use.
