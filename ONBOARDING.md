# Welcome to the Builtech Website Project

Hi! This guide will get you set up to work on the Builtech website. Read it top-to-bottom the first time. If anything is confusing, stop and ask Zufar — don't guess.

---

## What this project is

- **Live site:** https://bpmwebsite-revamp-main-nxlf3q.laravel.cloud
- **Admin panel:** `/admin` on the live site (Zufar will give you a login)
- **Tech stack:** Laravel 12 (PHP), Filament 5 (admin UI), Tailwind CSS, Postgres database (on the live server only — locally you'll use SQLite)
- **Hosting:** Laravel Cloud, which automatically deploys whenever code is merged into the `main` branch on GitHub

---

## 1. Install the tools you need

Do this **once** on your laptop. Install in this order:

| Tool | What it does | Download from |
|---|---|---|
| **Git** | Saves and shares code | https://git-scm.com/downloads |
| **PHP 8.4+** | Runs the website | https://windows.php.net/download/ (pick "Thread Safe x64" zip) — or use Laravel Herd: https://herd.laravel.com |
| **Composer** | Installs PHP packages | https://getcomposer.org/download |
| **Node.js 20+** | Compiles CSS/JS | https://nodejs.org (pick the LTS version) |
| **VS Code** | Code editor | https://code.visualstudio.com |

**Easiest path on Windows:** install **Laravel Herd** — it bundles PHP + Composer + a local web server in one installer. Then you only need Git, Node, and VS Code separately.

### VS Code extensions to install (open VS Code → Extensions tab → search and install each)

- PHP Intelephense
- Laravel Blade Snippets
- Tailwind CSS IntelliSense
- GitLens

### Verify everything works

Open a terminal (in VS Code: `Ctrl + ` ` `) and run each line. You should see version numbers, not errors:

```powershell
git --version
php --version
composer --version
node --version
npm --version
```

If any one says "command not found" or "is not recognized", stop and ask Zufar — don't proceed.

---

## 2. Get the code on your laptop (one-time setup)

```powershell
# Pick a folder for your projects, e.g. C:\dev
cd C:\dev

# Download the code from GitHub
git clone https://github.com/zooster90/bpmwebsite-revamp-.git
cd bpmwebsite-revamp-

# Install PHP packages
composer install

# Install JS packages
npm install

# Create your local config file
copy .env.example .env

# Generate the encryption key Laravel needs
php artisan key:generate

# Create the local SQLite database
New-Item -ItemType File -Path database/database.sqlite

# Build the database tables
php artisan migrate
```

If `php artisan migrate` asks "Would you like to create it?" — type `yes`.

---

## 3. Run the project locally

You need **two terminals open at the same time**:

**Terminal 1 — runs the website:**
```powershell
php artisan serve
```
This will print something like `Server running on http://127.0.0.1:8000` — open that in your browser. That's the site.

**Terminal 2 — rebuilds CSS/JS when you edit files:**
```powershell
npm run dev
```
Leave both running while you work. When you change a `.blade.php`, `.css`, or `.js` file, the browser will auto-refresh.

To stop either one: click on its terminal and press `Ctrl + C`.

---

## 4. The daily workflow (THIS IS THE IMPORTANT PART)

**Every change you make follows the same 5 steps.** Read this carefully — getting this wrong can break the live site.

### Step 1 — Make sure you have the latest code

```powershell
git checkout main
git pull
```

### Step 2 — Create a new branch for your change

Branch name should describe what you're doing. Use lowercase and dashes:

```powershell
git checkout -b fix/contact-form-validation
# or
git checkout -b feature/about-page-team-section
```

Good branch name prefixes:
- `fix/...` — fixing a bug
- `feature/...` — adding something new
- `style/...` — visual/CSS changes only
- `docs/...` — updating documentation

### Step 3 — Make your changes

Edit files. Save. Check it works in your browser at `http://127.0.0.1:8000`.

### Step 4 — Commit your work

```powershell
# See what you changed
git status

# Stage the files you want to commit (replace with actual file paths)
git add resources/views/contact.blade.php

# Or stage everything at once (safer than `git add .`)
git add -u

# Write a commit message describing WHAT and WHY
git commit -m "fix: contact form was not validating email format"
```

Good commit message examples:
- `fix: contact form was not validating email format`
- `feature: add team photos section to About page`
- `style: increase spacing between project cards on mobile`

Bad commit message examples (don't do these):
- `update` ❌
- `changes` ❌
- `fix bug` ❌ (which bug?)

### Step 5 — Push your branch and open a Pull Request

```powershell
git push -u origin fix/contact-form-validation
```

Then:
1. Go to https://github.com/zooster90/bpmwebsite-revamp-
2. You'll see a yellow banner saying "your branch had recent pushes — Compare & pull request" — click it
3. Write a short description of what your PR does and what to test
4. Click **Create pull request**
5. Send the PR link to Zufar in WhatsApp/Slack/wherever

Zufar will review, possibly ask for changes, and then merge it. Once merged, Laravel Cloud auto-deploys to the live site within a couple of minutes.

---

## 5. Hard rules — NEVER do these

| Don't do this | Why |
|---|---|
| ❌ **Never push directly to `main`** | `main` deploys straight to the live site. Branch protection should block you, but don't even try. |
| ❌ **Never commit `.env`** | It contains passwords. It's already in `.gitignore` — leave it that way. |
| ❌ **Never run `git push --force`** | This can delete other people's work permanently. |
| ❌ **Never delete branches you didn't create** | Ask first. |
| ❌ **Never run `rm -rf` or `Remove-Item -Recurse -Force`** unless you're 100% sure | Easy to delete things you didn't mean to. |
| ❌ **Never commit secrets, API keys, or passwords** | If you accidentally do, tell Zufar immediately — those need to be rotated. |
| ❌ **Never `composer update` without asking** | This can upgrade packages to incompatible versions. Use `composer install` to install what's already locked. |

---

## 6. When you get stuck

1. **Read the error message carefully** — Laravel error pages tell you exactly what file and line broke
2. **Google the error** — paste the first line of the error into Google with "Laravel" added
3. **Check git** — `git status` and `git diff` will tell you what you changed
4. **Ask Zufar** — share the error message + what you tried. Don't say "it doesn't work" with no context.

If you broke something locally and can't figure out what:

```powershell
# Throw away your uncommitted changes (CAREFUL — you lose your work)
git stash

# Or restore a specific file to its original state
git checkout -- path/to/file.php
```

---

## 7. Cheat sheet — commands you'll use every day

```powershell
# See what branch you're on and what's changed
git status

# See your recent commits
git log --oneline -10

# Switch to a different branch
git checkout branch-name

# Pull the latest from GitHub
git pull

# Throw away unsaved file changes
git checkout -- path/to/file

# Clear Laravel caches if something looks weird
php artisan optimize:clear

# Re-run database migrations from scratch (will erase local data!)
php artisan migrate:fresh
```

---

## 8. Project structure — where things live

```
app/
├── Filament/              ← The admin panel (you'll edit this a lot)
│   ├── Resources/         ← One file per admin section (Projects, News, etc.)
│   └── Widgets/           ← Dashboard widgets
├── Http/Controllers/      ← Frontend page logic (HomeController, AwardController, etc.)
├── Models/                ← One file per database table
└── Observers/             ← Reacts to model changes (e.g. cache invalidation)

resources/
├── views/                 ← Blade templates (HTML for the frontend)
│   ├── index.blade.php    ← Homepage
│   └── ...
├── css/                   ← Tailwind CSS
└── js/                    ← JavaScript

routes/
└── web.php                ← URL → controller mapping

database/
└── migrations/            ← Database schema changes
```

When you need to find something:
- "Where does the homepage get its data?" → `app/Http/Controllers/HomeController.php`
- "How does the homepage look?" → `resources/views/index.blade.php`
- "What URL maps to what?" → `routes/web.php`
- "How does the Projects admin section work?" → `app/Filament/Resources/ProjectResource.php`

---

## 9. Who to ask

**Zufar** — for code questions, access issues, "is this safe to do" questions, anything you're unsure about. **It's always better to ask than to guess.**

---

Welcome aboard 🎉
