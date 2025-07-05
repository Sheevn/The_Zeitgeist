# The Zeitgeist

A minimalist, flat-file, single-user PHP content management system for publishing thoughts, commentary, and digital artifacts without the noise of social media. No database required.

## The Philosophy

> *"Social media didn’t invent stupidity—but it industrialised it. It turned identity into a brand, belief into status, and thinking into a threat."*

The Zeitgeist was born from a desire for a digital sanctuary. It is an antidote to the endless cycle of performative outrage and the pressure to have a brand instead of a voice. It is not a platform for dialogue; it is a platform for declaration. It's a space to simply *say something* and let it stand on its own, immune to the churn of public commentary.

## Features

-   **Database-Free:** All content is stored in simple HTML and JSON files.
-   **Password-Protected Admin Panel:** A secure area to create, comment on, and manage your content.
-   **Automatic Google Analytics Injection:** Add your tracking ID once, and it will be automatically injected into every new HTML page you create.
-   **Built-in Dark/Light Mode:** A theme toggle that respects user preference and remembers the choice.
-   **Responsive Design:** A clean, modern layout that works beautifully on desktop and mobile.
-   **Pagination:** Automatically handles large amounts of content.
-   **Secure by Design:** Built with protections against common vulnerabilities like XSS and Directory Traversal.

---

## Getting Started

Follow these steps to get your own version of The Zeitgeist running.

### 1. Download the Code
Download or clone this repository to your web server.

### 2. Create Directories
In the main project folder, create two empty directories:
- `pages/`
- `comments/`

### 3. Set Permissions
Your web server needs permission to write to these new directories. Using an FTP client or your hosting control panel, set the permissions for both the `pages` and `comments` directories to `755`.

### 4. Secure Your Admin Panel
For security, it is highly recommended to rename the admin file.
- Rename `admin.php` to something obscure that only you will know (e.g., `z-panel-ax79.php`).
- Open the newly renamed file and change the placeholder password to something very long and secure.

```php
// Inside your renamed admin file
define('ADMIN_PASSWORD', 'change-this-to-a-very-strong-password!');
```

---

## Configuration & Customization

Make the site your own by editing these files.

### 1. Add Your Google Analytics ID
- Open your renamed **admin file**. Find the section for `$ga_script` and replace `G-XXXXXXXXXX` with your own Google Analytics Measurement ID.
- Open **`index.php`** and **`view.php`**. Find the Google Analytics script in the `<head>` section and replace `G-XXXXXXXXXX` with your ID there as well.

### 2. Customize the "About" Text
- Open **`index.php`** and **`view.php`**.
- Find the `div` with the ID `about-modal`. You can edit the text inside the `<div class="modal-content">` to reflect your own philosophy.

### 3. Add Your Social Media Link
- In the same `about-modal` section in **`index.php`** and **`view.php`**, find the link for "X" and replace the placeholder URL with your own social media profile.

```html
<p>...You can find me on <a href="https://twitter.com/your_handle" target="_blank" rel="noopener noreferrer">X</a>.</p>
```

### 4. Update the Footer
- In **`index.php`** and **`view.php`**, find the `<footer>` section and replace `[Your Name]` with your own name.

## License
This project is open source and available under the [MIT License](LICENSE).
