
# PanelPop

A minimal PHP-based e-commerce platform with basic customer and admin interfaces. Supports product listing, cart functionality, user authentication, and product management.

## 📁 Project Structure

- `index.php` - Landing page
- `login.php`, `register.php`, `logout.php` - User auth pages
- `genpass.php` - Password generation utility
- `includes/` - Common backend functions, DB config, auth checks
- `admin/` - Admin dashboard and product management 
- `customer/` - Customer dashboard, product view, cart & checkout
- `uploads/` - Product images
- `assets/` - Static assets (CSS, JS, media)

## 🔐 Authentication

User sessions are handled via PHP sessions. Separate interfaces for admin and customer roles.

## 🧪 Admin Interface
Product management tools for adding, editing, and deleting products.
### Admin UX

https://github.com/user-attachments/assets/b751865e-4ea4-449a-9f16-0950d6cdc538


## 🛒 Customer Interface

Product browsing, cart handling, and a checkout flow.
### CustomerUX


https://github.com/user-attachments/assets/3827659d-d34b-4ab1-aba2-8a8d89f8135b



## 📝 Notes

- Basic styling and layout via CSS under `/assets`
- No framework; pure PHP and minimal JavaScript

