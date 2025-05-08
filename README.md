# PWM Vote

PWM Vote is a web-based voting application developed using the Laravel PHP framework and the [Filament Admin Panel](https://filamentphp.com/). It is designed to facilitate secure and efficient voting processes, suitable for organizational elections, surveys, and other decision-making activities.

## Features

- **Filament Admin Panel**: Intuitive and powerful admin interface built using Filament for managing users, candidates, and voting settings.
- **User Authentication**
- **Role-Based Access Control**
- **Candidate Management**
- **Secure Voting System**
- **Real-Time Results**
- **Audit Logs**
- **Responsive Design**

## Tech Stack

- Laravel 10+
- Filament PHP (v3)
- MySQL or compatible DB
- Tailwind CSS (via Filament)
- Livewire

## Installation

```bash
git clone https://github.com/aslammaududy/pwm-vote.git
cd pwm-vote

composer install
npm install
npm run dev

cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
```
## Usage
- Admin login and management through Filament Admin Panel.
- Users can log in, view elections, and cast votes.
- Real-time result display and logs via the dashboard.

