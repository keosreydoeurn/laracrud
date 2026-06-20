<template>
  <div id="app">
    <Navbar />
    <main class="container mt-4">
      <div class="page-wrapper">
        <router-view />
      </div>
    </main>
    <footer class="footer mt-5 py-3 bg-light">
      <div class="container text-center">
        <span class="text-muted">© 2026 Simple Blog. All rights reserved.</span>
      </div>
    </footer>
  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue'
</script>

<style>
:root {
  --primary-color: #4a6cf7;
  --primary-dark: #3a56d4;
  --secondary-color: #6c757d;
  --success-color: #28a745;
  --danger-color: #dc3545;
  --warning-color: #ffc107;
  --info-color: #17a2b8;
  --light-bg: #f8f9fa;
  --dark-bg: #343a40;
  --text-color: #333333;
  --text-light: #6c757d;
  --border-radius: 8px;
  --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  --transition: all 0.3s ease;
  --text: #6b6375;
  --text-h: #08060d;
  --bg: #fff;
  --border: #e5e4e7;
  --code-bg: #f4f3ec;
  --accent: #aa3bff;
  --accent-bg: rgba(170, 59, 255, 0.1);
  --accent-border: rgba(170, 59, 255, 0.5);
  --shadow: rgba(0, 0, 0, 0.1) 0 10px 15px -3px, rgba(0, 0, 0, 0.05) 0 4px 6px -2px;
  --sans: system-ui, 'Segoe UI', Roboto, sans-serif;
  --heading: system-ui, 'Segoe UI', Roboto, sans-serif;
  --mono: ui-monospace, Consolas, monospace;
}

@media (prefers-color-scheme: dark) {
  :root {
    --text: #9ca3af;
    --text-h: #f3f4f6;
    --bg: #16171d;
    --border: #2e303a;
    --code-bg: #1f2028;
    --accent: #c084fc;
    --accent-bg: rgba(192, 132, 252, 0.15);
    --accent-border: rgba(192, 132, 252, 0.5);
    --shadow: rgba(0, 0, 0, 0.4) 0 10px 15px -3px, rgba(0, 0, 0, 0.25) 0 4px 6px -2px;
  }
}

body {
  margin: 0;
  font: 18px/145% var(--sans);
  letter-spacing: 0.18px;
  color-scheme: light dark;
  color: var(--text);
  background: var(--bg);
  font-synthesis: none;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

#app {
  min-height: 100vh;
  background-color: #f0f2f5;
  display: flex;
  flex-direction: column;
}

.page-wrapper {
  background: white;
  border-radius: var(--border-radius);
  padding: 2rem;
  box-shadow: var(--box-shadow);
  min-height: 400px;
}

.footer {
  margin-top: auto;
  border-top: 1px solid #e9ecef;
}

.navbar {
  background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
  border-bottom: 2px solid var(--accent);
  padding: 0.75rem 0;
}

.navbar-brand {
  font-weight: 700;
  font-size: 1.4rem;
  color: white !important;
  letter-spacing: -0.5px;
}

.navbar-brand:hover {
  color: var(--accent) !important;
  transition: color 0.3s ease;
}

.nav-link {
  color: rgba(255, 255, 255, 0.8) !important;
  font-weight: 500;
  padding: 0.5rem 1rem !important;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: white !important;
  background: rgba(255, 255, 255, 0.1);
}

.nav-link.router-link-active {
  color: var(--accent) !important;
  background: rgba(170, 59, 255, 0.15);
}

.post-card {
  border: 1px solid var(--border);
  border-radius: 12px;
  background: var(--bg);
  padding: 1.5rem;
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.post-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow);
  border-color: var(--accent-border);
}

.category-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 600;
  background: var(--accent-bg);
  color: var(--accent);
  border: 1px solid var(--accent-border);
  transition: all 0.3s ease;
}

.category-badge:hover {
  background: var(--accent);
  color: white;
}

.btn {
  border-radius: 8px;
  font-weight: 600;
  padding: 0.6rem 1.5rem;
  transition: all 0.3s ease;
}

.btn-primary {
  background: var(--accent);
  border-color: var(--accent);
  color: white;
}

.btn-primary:hover {
  background: var(--accent);
  opacity: 0.85;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(170, 59, 255, 0.4);
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in-up {
  animation: fadeInUp 0.5s ease forwards;
}

@media (max-width: 768px) {
  .post-card {
    padding: 1rem;
  }
  .page-wrapper {
    padding: 1rem;
  }
}
</style>