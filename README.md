# CodeIgniter 4 - Government Tenders Application

## Environment Configuration

Copy this file to `.env` and configure the values for your environment.

### Application Settings
```
CI_ENVIRONMENT = development
app.baseURL = http://localhost:8080
```

### Database Configuration
```
db.default.hostname = localhost
db.default.username = root
db.default.password = 
db.default.database = tender_notifications
db.default.DBDriver = MySQLi
```

### Email Configuration
```
email.protocol = smtp
email.SMTPHost = smtp.mailtrap.io
email.SMTPUser = your-mailtrap-user
email.SMTPPass = your-mailtrap-password
email.SMTPPort = 465
email.SMTPEncrypto = ssl
email.from = noreply@govtenders.local
email.fromName = Government Tenders
```

### Treasury API Configuration
```
TREASURY_API_URL = https://ocds-api.etenders.gov.za/swagger/v1/swagger.json
TREASURY_API_KEY = your-api-key-here
```

### Push Notification Configuration

#### Firebase Cloud Messaging (FCM)
```
FCM_SERVER_KEY = your-fcm-server-key
```

#### SMS Configuration (Bulk SMS)
```
SMS_PROVIDER = bulk-sms
BULKSMS_USERNAME = your-username
BULKSMS_PASSWORD = your-password
```

### Session Configuration
```
session.driver = files
session.cookieName = CITSESSID
session.expiration = 7200
session.savePath = null
session.matchIP = false
session.timeToUpdate = 300
session.regenerateDestroy = false
```

## Installation Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd tender_notifications
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your configuration
   ```

4. **Run database migrations**
   ```bash
   php spark migrate
   ```

5. **Seed initial data**
   ```bash
   php spark db:seed InitialDataSeeder
   ```

6. **Start development server**
   ```bash
   php spark serve
   ```

7. **Access the application**
   ```
   http://localhost:8080
   ```

## Features Implemented

- ✅ Browse government tenders with filtering
- ✅ Advanced search functionality
- ✅ User registration and authentication
- ✅ Push notification subscriptions
- ✅ Email notifications
- ✅ SMS notifications
- ✅ Treasury API integration
- ✅ Responsive Bootstrap UI
- ✅ Tender document management
- ✅ Briefing session tracking
- ✅ Enquiry contact information

## API Endpoints

### Public Endpoints
- `GET /` - Homepage with tender listing
- `GET /tender/view/:id` - View tender details
- `GET /api/tenders` - Get tenders (JSON)
- `GET /api/tender/:id` - Get tender details (JSON)

### Authentication Endpoints
- `GET /auth/register` - Registration page
- `POST /auth/register` - Register new user
- `GET /auth/login` - Login page
- `POST /auth/login` - Authenticate user
- `GET /auth/logout` - Logout user

### User Endpoints (Authenticated)
- `GET /subscription` - View subscriptions
- `GET /subscription/create` - Create new subscription
- `POST /subscription/create` - Store new subscription
- `POST /subscription/delete/:id` - Delete subscription
- `POST /subscription/register-push-token` - Register push token

## Database Schema

### Key Tables
- `tenders` - Tender listings
- `categories` - Tender categories
- `organs_of_state` - Government organs
- `provinces` - Geographic provinces
- `tender_enquiries` - Enquiry contacts for tenders
- `briefing_sessions` - Briefing session details
- `tender_documents` - Downloadable tender documents
- `users` - User accounts
- `user_subscriptions` - User notification subscriptions
- `tender_categories` - Many-to-many relationship

## File Structure

```
app/
├── Config/
│   ├── Database.php         # Database configuration
│   └── Routes.php           # Route definitions
├── Controllers/
│   ├── Home.php             # Homepage controller
│   ├── Tender.php           # Tender detail controller
│   ├── Auth.php             # Authentication controller
│   ├── Subscription.php     # Subscription management
│   └── Api.php              # API endpoints
├── Models/
│   ├── TenderModel.php
│   ├── CategoryModel.php
│   ├── UserModel.php
│   ├── UserSubscriptionModel.php
│   └── ... (other models)
├── Services/
│   ├── TreasuryAPIService.php    # External API integration
│   └── PushNotificationService.php # Notification handling
└── Views/
    ├── layout.php           # Base layout template
    ├── home.php             # Homepage view
    ├── tender/
    │   └── view.php         # Tender detail view
    ├── auth/
    │   ├── login.php
    │   └── register.php
    └── subscription/
        ├── index.php
        └── create.php
```

## Notes

- The application uses Bootstrap 5 for responsive design
- Database uses MySQL with InnoDB engine
- Migrations are numbered for proper sequencing
- Services layer handles external API calls and notifications
- All user input is validated and sanitized
- Password hashing uses PHP's `password_hash()` with BCRYPT

## Security Considerations

- Implement HTTPS in production
- Use environment variables for sensitive data
- Enable CSRF protection (enabled by default in CI4)
- Validate and sanitize all input
- Use prepared statements (handled by ORM)
- Implement rate limiting for API endpoints
- Use strong password requirements
- Log all important user actions

## Future Enhancements

- Admin dashboard for tender management
- Advanced analytics and reporting
- Tender comparison feature
- PDF export functionality
- Mobile app with native push notifications
- Tender recommendation engine
- API rate limiting and throttling
- 2FA authentication
- OAuth integration
- Tender bidding system
