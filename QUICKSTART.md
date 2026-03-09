# Government Tenders Application - Quick Start Guide

## 🚀 Quick Setup (5 minutes)

### Step 1: Environment Setup
```bash
# Copy environment template
cp .env.example .env

# Edit .env with your settings (at minimum):
# - Database credentials
# - Email settings
# - API keys
```

### Step 2: Database Setup
```bash
# Run migrations
php spark migrate

# Seed sample data
php spark db:seed InitialDataSeeder
```

### Step 3: Start Server
```bash
# Development server
php spark serve

# Access at http://localhost:8080
```

## 📋 Core Features

### 1. Browse Tenders
- **URL:** `/`
- **Features:**
  - Responsive tender listing
  - Filter by province, organ, category, type
  - Search functionality
  - Pagination
  - Status indicators

### 2. View Tender Details
- **URL:** `/tender/view/{id}`
- **Includes:**
  - Complete tender information
  - Contact details for enquiries
  - Briefing session schedules
  - Downloadable documents
  - Share and print options

### 3. User Authentication
- **Register:** `/auth/register`
- **Login:** `/auth/login`
- **Logout:** `/auth/logout`

### 4. Manage Subscriptions
- **View Subscriptions:** `/subscription`
- **Create Subscription:** `/subscription/create`
- **Notification Types:**
  - Email notifications
  - Push notifications
  - SMS notifications

## 🔌 API Endpoints

### Public API
```
GET  /api/tenders              - List tenders with filters
GET  /api/tender/:id           - Get tender details
GET  /api/tender-types         - Get available types
```

### Query Parameters
```
page=1              - Pagination
perPage=10          - Items per page
search=text         - Search query
category_id=1       - Filter by category
province_id=1       - Filter by province
organ_of_state_id=1 - Filter by organ
tender_type=goods   - Filter by type (goods, services, works)
```

### Example Request
```bash
curl "http://localhost:8080/api/tenders?province_id=1&page=1&perPage=20"
```

## 🛠️ Configuration

### Email Setup (for notifications)
1. Get SMTP credentials from your email provider (Mailtrap, SendGrid, etc.)
2. Update `.env`:
   ```
   email.SMTPHost = your-host
   email.SMTPUser = your-user
   email.SMTPPass = your-password
   ```

### Treasury API Integration
1. Get API key from Treasury Department
2. Update `.env`:
   ```
   TREASURY_API_URL = https://api.treasury.gov.za/tenders
   TREASURY_API_KEY = your-key
   ```

3. Sync tenders:
   ```bash
   php spark sync:tenders
   ```

### Push Notifications (Firebase)
1. Setup Firebase Cloud Messaging
2. Get server key from Firebase Console
3. Update `.env`:
   ```
   FCM_SERVER_KEY = your-fcm-key
   ```

## 📱 Frontend Customization

### Colors & Branding
Edit `app/Views/layout.php` CSS variables:
```css
--primary-color: #1e3a8a;
--secondary-color: #0f766e;
--accent-color: #dc2626;
```

### Responsive Breakpoints
- Mobile: < 576px
- Tablet: 576px - 992px  
- Desktop: > 992px

Uses Bootstrap 5 Grid System

## 🗄️ Database Schema

### Main Tables
```
tenders
├── id, tender_number, title, description
├── organ_of_state_id (FK)
├── province_id (FK)
├── tender_type, status
├── opening_date, closing_date, published_date
└── budget_estimate, api_id

tender_enquiries
├── tender_id (FK)
├── contact_person, email, phone, fax

briefing_sessions
├── tender_id (FK)
├── date, time, venue
├── is_virtual, virtual_link

tender_documents
├── tender_id (FK)
├── document_name, file_path, file_type, file_size
└── download_count

users
├── email (unique), password_hash
├── first_name, last_name, phone, organization
└── is_active

user_subscriptions
├── user_id (FK)
├── notification_type (email|push|sms)
├── filter_type, filter_value
└── push_token (for push notifications)
```

## 🧪 Testing

### Create Test User
```bash
# Via database
INSERT INTO users (email, password_hash, first_name, last_name, is_active)
VALUES ('test@example.com', '$2y$10$...', 'Test', 'User', 1);
```

### Add Sample Tenders
Use the seeder or API to manually add tenders

### Test Notifications
1. Create a user and subscribe
2. Add a new tender
3. Check email/push notifications

## 🔐 Security Checklist

- [ ] Change default database credentials
- [ ] Set encryption.key in `.env`
- [ ] Enable HTTPS in production
- [ ] Configure CORS if needed
- [ ] Setup rate limiting for APIs
- [ ] Validate all file uploads
- [ ] Use environment variables for secrets
- [ ] Enable security headers
- [ ] Setup logging and monitoring
- [ ] Regular database backups

## 📚 Additional Commands

```bash
# Run migrations
php spark migrate

# Rollback migrations
php spark migrate:rollback

# Create migration
php spark make:migration create_table_name

# Seed database
php spark db:seed InitialDataSeeder

# Create model
php spark make:model ModelName

# Create controller
php spark make:controller ControllerName

# Sync tenders from API
php spark sync:tenders

# Clear cache
php spark cache:clear
```

## 🐛 Troubleshooting

### Database connection error
- Check database credentials in `.env`
- Ensure MySQL is running
- Verify database exists

### Email not sending
- Check SMTP settings
- Verify email credentials are correct
- Check email logs in `writable/logs/`

### API integration not working
- Verify API key is correct
- Check API URL is accessible
- Review API response in logs

### Push notifications not working
- Verify FCM server key
- Ensure user has registered push token
- Check browser notification permissions

## 📞 Support

For issues or questions:
1. Check the logs in `writable/logs/`
2. Review the error in browser console
3. Check database for data integrity
4. Review CodeIgniter documentation

## 📖 Useful Resources

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/index.html)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Firebase Documentation](https://firebase.google.com/docs/)

## 🎉 You're Ready!

The application is fully functional and ready for:
- Development
- Testing
- Deployment

Enjoy browsing government tenders! 🎊
