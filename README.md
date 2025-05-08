# Project Title

A full-stack web application built with **Laravel (Backend)** and **Vue.js 3 (Frontend)**.

---

## 🛠 Backend – Laravel

### Framework
- Laravel 12+ (PHP 8.2+)

### Packages Used
- **guzzlehttp/guzzle** – HTTP requests
- **barryvdh/laravel-debugbar** – Debugging tool for development
- **fruitcake/laravel-cors** – CORS handling
- **tymon/jwt-auth** – API authentication
- **laravel-ide-helper** – IDE support for helper methods (dev only)

### Features
- RESTful API With Repository Pattern
- JWT or Sanctum-based authentication
- Reusable validation & form request classes
  
### Command
- cp .env.example .env
- composer update
- php artisan key:generate
- php artisan migrate:fresh --seed
- php artisan test


---

## 🎨 Frontend – Vue.js 3

### Tech Stack
- **Vue 3**
- **Vuex** (with `vuex-persistedstate`)
- **Vue Router**
- **Axios**
- **Tailwind CSS**

### Dependencies

#### Core:
- `vue` – Reactive frontend framework
- `vue-router` – Routing and navigation
- `vuex` – Centralized state management
- `vuex-persistedstate` – State persistence using localStorage
- `axios` – For REST API calls

#### UI & Styling:
- `tailwindcss` – Utility-first CSS framework
- `postcss`, `autoprefixer` – CSS tooling for production-ready styles
- `vue-sweetalert2` – Alert and confirmation dialog boxes

#### Development Tools:
- `@babel/core`, `@babel/eslint-parser` – Babel support
- `@vue/cli-plugin-babel`, `@vue/cli-plugin-eslint`, `@vue/cli-service` – Vue CLI build tools
- `eslint`, `eslint-plugin-vue` – Linting and code standards
- `vue-cli-plugin-tailwind` – Tailwind integration with Vue CLI

### Features
- Composition API and component-based design
- Vue Router navigation guards (role-based)
- Vuex state management with token persistence
- SweetAlert2 for elegant modals and confirmations
- Fully responsive UI using Tailwind CSS
- Real-time form error display and alert messages
- Axios-based secure API communication

---

## 🧪 Getting Started

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git

