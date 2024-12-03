# Laravel File and Directory Explorer

This project is a simple file and directory explorer built with Laravel and styled using Tailwind CSS. The application allows users to navigate through directories, view files, and interact with a file system interface.

---

## Features

-   **Directory Navigation**: Browse through directories dynamically.
-   **File Listing**: View files within the selected directory.
-   **Breadcrumb Navigation**: See the current directory path.
-   **Responsive Design**: Optimized for various screen sizes using Tailwind CSS.

---

## Requirements

-   PHP >= 8.1
-   Composer
-   Laravel >= 10
-   Node.js & npm/yarn (for Tailwind CSS compilation)

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laravel-file-explorer.git
cd laravel-file-explorer
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the `.env.example` file and configure your environment variables:

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000/explorer` to use the application.

---

## Usage

### Routes

-   `/explorer`: Main interface for file and directory navigation.

### Directory Navigation

-   Click on a directory name to navigate into it.
-   Files and subdirectories in the current directory will be displayed.

---

## File Structure

```
├── app
│   ├── Http
│   │   └── Controllers
│   │       └── FileExplorerController.php
├── resources
│   ├── views
│   │   └── explorer
│   │       └── index.blade.php
├── routes
│   └── web.php
```

---

## Tailwind CSS Integration

To customize Tailwind CSS:

1. Install Tailwind CSS:
    ```bash
    npm install -D tailwindcss postcss autoprefixer
    npx tailwindcss init
    ```
2. Configure `tailwind.config.js`:
    ```javascript
    module.exports = {
        content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
        theme: {
            extend: {},
        },
        plugins: [],
    };
    ```
3. Compile Tailwind:
    ```bash
    npm run dev
    ```

---

## Contributing

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -m 'Add feature'`
4. Push to the branch: `git push origin feature-name`
5. Open a pull request.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
