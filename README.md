
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
###Admin UX
https://github.com/user-attachments/assets/59e71702-f02d-4e31-a9f0-41c3a701fddb

## 🛒 Customer Interface

Product browsing, cart handling, and a checkout flow.
###CustomerUX
https://github.com/user-attachments/assets/34bd13dc-7239-4479-bb6f-24c1bfd3760d

## 📝 Notes

- Basic styling and layout via CSS under `/assets`
- No framework; pure PHP and minimal JavaScript

