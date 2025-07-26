# 🎉 SG.Events - Event Management System

A modern, full-featured event management platform built with Laravel 12, Bootstrap 5, and Tailwind CSS. This application allows organizers to create and manage events while providing users with an intuitive interface to discover and participate in events.

## 📋 Table of Contents

- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Database Structure](#-database-structure)
- [Project Structure](#-project-structure)
- [Usage](#-usage)
- [API Endpoints](#-api-endpoints)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🎯 Core Features
- **Event Management**: Create, edit, and manage events with rich details
- **Organizer Profiles**: Complete organizer management with contact information
- **Event Categories**: Categorize events for better organization
- **Location Management**: Support for regions and cities
- **Event Status Tracking**: Track events through various statuses (new, updated, published, canceled, passed)
- **Image Management**: Upload and manage event and organizer images
- **Event Versioning**: Track changes to events over time
- **Event Statistics**: Monitor event performance and engagement

### 🎨 User Interface
- **Modern Design**: Clean, responsive design using Bootstrap 5 and Tailwind CSS
- **Event Carousel**: Showcase latest events on the homepage
- **Advanced Filtering**: Filter events by category, region, city, date, time, and search
- **Pagination**: Efficient event browsing with 9 events per page
- **Event Details**: Comprehensive event information with organizer details
- **Organizer Modal**: Detailed organizer information in modern modal windows
- **Responsive Layout**: Optimized for desktop, tablet, and mobile devices

### 🔐 Authentication & Security
- **Laravel Breeze**: Built-in authentication system
- **Email Verification**: Secure email verification for user accounts
- **Password Management**: Password reset and update functionality
- **Admin Middleware**: Role-based access control
- **CSRF Protection**: Built-in CSRF token protection

### 📧 Email Notifications
- **Event Published**: Notify organizers when events are published
- **Event Updates**: Notify when events can be edited
- **Account Creation**: Welcome emails for new organizer accounts
- **Update Requests**: Notify admins of event update requests

## 🛠 Technology Stack

### Backend
- **Laravel 12**: Modern PHP framework
- **PHP 8.2+**: Latest PHP version with modern features
- **MySQL/PostgreSQL**: Database support
- **Eloquent ORM**: Database abstraction layer
- **Laravel Breeze**: Authentication scaffolding

### Frontend
- **Bootstrap 5**: CSS framework for responsive design
- **Tailwind CSS**: Utility-first CSS framework
- **Bootstrap Icons**: Icon library
- **Alpine.js**: Lightweight JavaScript framework
- **Vite**: Modern build tool

### Development Tools
- **Laravel Pint**: PHP code style fixer
- **Pest**: Testing framework
- **Laravel Sail**: Docker development environment
- **Laravel Pail**: Log viewer

### Additional Packages
- **Laravel DomPDF**: PDF generation
- **Maatwebsite Excel**: Excel import/export functionality

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL/PostgreSQL database
- Web server (Apache/Nginx)

### Step 1: Clone the Repository
```bash
git clone <repository-url>
cd event-management-system
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Setup
```bash
# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed
```

### Step 5: Storage Setup
```bash
# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache
```

### Step 6: Build Assets
```bash
# Build for development
npm run dev

# Build for production
npm run build
```

### Step 7: Start the Application
```bash
# Start Laravel development server
php artisan serve

# Or use Laravel Sail (Docker)
./vendor/bin/sail up
```

## ⚙️ Configuration

### Mail Configuration
Configure your mail settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="${APP_NAME}"
```

### File Upload Configuration
Configure file upload settings in `config/filesystems.php`:
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

## 🗄 Database Structure

### Core Tables
- **users**: User accounts and authentication
- **events**: Main events table with all event details
- **organizers**: Organizer profiles and information
- **categories**: Event categories
- **regions**: Geographic regions
- **cities**: Cities within regions
- **event_stats**: Event statistics and analytics
- **event_versions**: Event version history
- **organizer_historics**: Organizer activity history
- **canceled_events**: Canceled events tracking

### Key Relationships
- Events belong to Organizers
- Events belong to Categories, Regions, and Cities
- Organizers belong to Users
- Events have many Event Versions
- Events have one Event Stats record

## 📁 Project Structure

```
event-management-system/
├── app/
│   ├── Http/Controllers/          # Application controllers
│   │   ├── Auth/                  # Authentication controllers
│   │   ├── EventController.php    # Event management
│   │   ├── OrganizerController.php # Organizer management
│   │   └── UserInterfaceController.php # Public interface
│   ├── Models/                    # Eloquent models
│   │   ├── Event.php             # Event model
│   │   ├── Organizer.php         # Organizer model
│   │   ├── User.php              # User model
│   │   └── ...                   # Other models
│   ├── Mail/                     # Email notifications
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Database migrations
│   ├── seeders/                  # Database seeders
│   └── factories/                # Model factories
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── userInterface/        # Public interface views
│   │   ├── auth/                 # Authentication views
│   │   └── components/           # Reusable components
│   ├── css/                      # Stylesheets
│   └── js/                       # JavaScript files
├── routes/
│   ├── web.php                   # Web routes
│   └── auth.php                  # Authentication routes
├── public/
│   ├── images/                   # Uploaded images
│   └── storage/                  # Storage symlink
└── storage/
    └── app/public/               # File storage
```

## 🎮 Usage

### For Event Organizers
1. **Register/Login**: Create an account or log in
2. **Create Events**: Add new events with detailed information
3. **Manage Events**: Edit, update, and track event status
4. **View Analytics**: Monitor event performance and statistics

### For Event Attendees
1. **Browse Events**: View all published events
2. **Filter & Search**: Find events by category, location, date, etc.
3. **Event Details**: View comprehensive event information
4. **Contact Organizers**: Get in touch with event organizers

### For Administrators
1. **User Management**: Manage user accounts and permissions
2. **Event Moderation**: Review and approve events
3. **Category Management**: Manage event categories
4. **Location Management**: Manage regions and cities
5. **System Monitoring**: Monitor system performance and statistics

## 🔌 API Endpoints

### Public Routes
- `GET /` - Homepage
- `GET /Événements` - Events listing with filters
- `GET /événements/{event}` - Individual event details

### Protected Routes (Authentication Required)
- `GET /dashboard` - Admin dashboard
- `GET /events` - Event management
- `POST /events` - Create new event
- `PUT /events/{event}` - Update event
- `GET /organizers` - Organizer management
- `POST /organizers` - Create organizer
- `GET /parametres/categories` - Category management
- `GET /parametres/regions` - Region management
- `GET /parametres/cities` - City management

## 🎨 Frontend Features

### Homepage Components
- **Navigation Bar**: Responsive navigation with search
- **Hero Section**: Featured content and call-to-action
- **Events Carousel**: Latest events displayed 3x3
- **Services Section**: "Why Choose Us" with 6 service cards
- **Footer**: Modern footer with links and information

### Event Listing Page
- **Filter Bar**: Advanced filtering options
- **Event Grid**: Responsive event cards
- **Pagination**: 9 events per page
- **Search Functionality**: Real-time search

### Event Details Page
- **Event Image**: Large event image display
- **Organizer Information**: Compact organizer preview
- **Event Details**: Comprehensive event information
- **Organizer Modal**: Detailed organizer information
- **Related Events**: Similar events suggestions

## 🔧 Development

### Code Style
The project uses Laravel Pint for code style enforcement:
```bash
# Check code style
./vendor/bin/pint --test

# Fix code style
./vendor/bin/pint
```

### Testing
The project uses Pest for testing:
```bash
# Run tests
php artisan test

# Run tests with coverage
php artisan test --coverage
```

### Database Migrations
```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow Laravel coding standards
- Write tests for new features
- Update documentation as needed
- Ensure responsive design compatibility
- Test across different browsers and devices

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

## 🙏 Acknowledgments

- Laravel team for the amazing framework
- Bootstrap team for the UI components
- All contributors who helped build this project

---

**Made with ❤️ by the SG.Events Team**
