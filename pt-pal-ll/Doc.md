Employees submit lessons (problem, root cause, solution, recommendation), reviewers approve or return them for revision, and published lessons become searchable, taggable, and reusable knowledge for future projects.

## Stack

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Blade + Livewire 3 + Tailwind CSS
- **Database:** SQLite (local dev) — MySQL specified for production
- **Environment:** Windows, VS Code, XAMPP, Composer, Node/NPM, Git

## Features

- Full lesson lifecycle: draft → submit → review → approve/return → publish
- Role-based access control (employee, reviewer, admin) via Laravel Policies
- Departments, projects, categories, and tags — manageable through an admin panel
- Search and filters (title, problem, solution, status, department)
- Sort by newest, most viewed, or most bookmarked
- Related lessons (deterministic matching by category + shared tags)
- Comments/discussion threads on lessons
- Bookmarks and a personal "My Contributions" page
- Private file attachments (validated type/size, random filenames, authorized downloads only)
- Dedicated Review Queue for reviewers
- Full audit logging (logins, lesson lifecycle events, uploads, downloads)
- Rate limiting on comments and attachment downloads
- Automated authorization tests (negative + positive cases)

## Getting started

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run dev
php artisan serve
```

Visit `http://127.0.0.1:8000`, register an account, then promote yourself via Tinker to test reviewer/admin features:

```bash
php artisan tinker
```
```php
\App\Models\User::find(1)->update(['role' => 'admin']);
```

## Roles

| Role | Can do |
|---|---|
| Employee | Create/edit own drafts, submit for review, comment, bookmark |
| Reviewer | Approve or return submitted lessons |
| Admin | Manage departments, projects, categories, tags |

## Testing

```bash
php artisan test
```

Includes negative authorization tests confirming users can't edit others' lessons, can't approve without the reviewer role, and unauthenticated requests are properly redirected.

## Notes

- Local development uses SQLite for simplicity; the original design spec targets MySQL for production.
- File attachments are stored privately (`storage/app/private`) and served only through an authorized download route — never publicly accessible by URL.
- This is a prototype. Production deployment, SSO integration, and malware scanning require PT PAL IT/security approval before go-live.