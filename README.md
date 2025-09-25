# Work Connect

A comprehensive Laravel web application that connects job seekers ("workers") and employers ("bosses") with advanced job management, multi-day support, and intelligent worker availability tracking.

## 🚀 Latest Updates (August 2025)

### ✅ **History & Feedback System**
- **Work History**: Complete tracking of completed jobs and work assignments
- **Employer Feedback**: 5-star rating system with detailed written feedback
- **Worker Reviews**: Workers can view employer feedback and ratings received
- **Feedback Notifications**: Dashboard alerts for pending feedback
- **Interactive Rating**: Star-based rating system with hover effects
- **History Navigation**: Easy access to completed work through dropdown menu

### ✅ **Job Completion & Feedback Workflow**
- **End Job Functionality**: Employers can manually end jobs and trigger feedback process
- **Worker Availability**: Workers automatically become available after job completion
- **Feedback Collection**: Employers prompted to rate workers after job completion
- **Feedback Validation**: Only employers can give feedback for their own completed jobs
- **Feedback History**: Complete audit trail of all ratings and feedback

### ✅ **Enhanced User Experience**
- **History Menu**: Added "History" option below "Settings" in user dropdown
- **Dashboard Integration**: Pending feedback notifications on employer dashboard
- **Responsive Design**: History views work seamlessly on all device sizes
- **Visual Feedback**: Color-coded status badges and star ratings
- **Quick Actions**: Direct links to history from dashboard

### ✅ **Multi-Day Job Support**
- **Date Range Jobs**: Employers can create jobs spanning multiple days/weeks/months
- **Duration Tracking**: Automatic calculation of job duration and total costs
- **Work Schedules**: Detailed daily breakdown for multi-day jobs
- **Cost Management**: Real-time total cost calculation (daily rate × duration)
- **Smart Warnings**: Alerts for long-term jobs (>7 days) with best practice suggestions

### ✅ **Job Completion & Worker Management**
- **Automatic Completion**: Jobs automatically marked as completed when duration ends
- **Worker Availability Restrictions**: Workers cannot become available while working on active jobs
- **Boss Controls**: Employers can remove individual workers or end entire jobs early
- **Active Worker Tracking**: Real-time monitoring of workers currently on jobs

### ✅ **Enhanced Navigation & User Experience**
- **Role-Based Navigation**: Employers see "Post Job", "My Jobs", "Active Workers" (no "Browse Jobs")
- **Workers see**: "Browse Jobs", "My Job Offers", "My Applications"
- **Active Workers Dashboard**: Employers can manage workers and view job progress
- **Worker Dashboard**: Shows active jobs and prevents availability toggle when working

### ✅ **Administrative Data Management**
- **Geographic Hierarchy**: Complete Rwanda administrative structure (Provinces → Districts → Sectors → Cells → Villages)
- **Pickup Points**: Designated meeting locations for job coordination
- **Location-Based Matching**: Workers matched based on administrative location and pickup points

### ✅ **Admin Panel (New)**
- **Admin Role**: New `admin` role with dedicated dashboard
- **User Management**: Search/filter users, suspend/reactivate, reset passwords, verify worker documents
- **Jobs Control**: View all jobs, force close, delete inappropriate jobs
- **Offers & Applications**: View all offers/applications, reassign offers across workers
- **Administrative Data CRUD**: Manage provinces, districts, sectors, cells, villages, and pickup points
- **Categories & Skills**: Manage job categories and worker skills
- **Disputes/Reports**: Review and resolve reported users or jobs
- **Exports**: CSV export for users, jobs, offers, applications, and administrative data

### ✅ Worker Profile & Pickup Points (Updated)
- Worker Settings now include full administrative location: Province → District → Sector → Cell → Village
- Pickup Point select filters to points assigned to the chosen village
- Workers can upload National ID and Experience images in Settings
- Availability toggle uses saved pickup point; location comes from profile

### ✅ Job Posting Location Selection (Updated)
- When posting a job, employers can select administrative locations: Province → District → Sector → Cell → Village
- Pickup points are automatically filtered to show only those assigned to the selected village
- Cascading dropdowns ensure proper location hierarchy and pickup point availability

### ✅ Admin Pickup Point Management (Updated)
- When creating a pickup point, admin selects Province → District → Sector → Cell → Village (bound to exact village)
- Pickup points list displays the village

## Features

### For Workers (Job Seekers)
- **User Registration & Authentication**: Secure account creation with role-based access
- **Smart Job Browsing**: Browse jobs with location-based filtering and category matching
- **Job Applications**: Apply for jobs with detailed cover letters and status tracking
- **Job Offers System**: Receive and manage job offers from employers
- **Availability Management**: Toggle availability status with location requirements
- **Active Job Tracking**: View current work assignments and earnings
- **Work History**: View completed jobs and employer feedback received
- **Performance Reviews**: See ratings and feedback from previous employers
- **Multi-Day Job Support**: See job duration, total earnings, and work schedules
- **AI-Powered Insights**: Personalized job recommendations and profile enhancement suggestions

### For Employers (Bosses)
- **Advanced Job Posting**: Create jobs with date ranges, duration tracking, and cost calculation
- **Worker Selection**: Choose from available workers based on location and skills
- **Job Offer Management**: Send job offers to selected workers and track responses
- **Active Worker Management**: Monitor workers currently on jobs with contact information
- **Job Control**: Remove individual workers or end entire jobs early
- **Worker Feedback System**: Rate and provide feedback for completed work
- **Performance Analytics**: Track job performance, applications, and worker statistics
- **Work History Management**: View completed jobs and manage feedback for workers
- **Feedback Notifications**: Dashboard alerts for pending worker feedback
- **Multi-Day Project Support**: Manage long-term projects with detailed scheduling
- **Cost Transparency**: Real-time total cost calculation and budget management

### AI Integration & Smart Features
- **Intelligent Matching**: Location-based worker-employer matching
- **Availability Intelligence**: Automatic worker availability based on active jobs
- **Duration Optimization**: Smart warnings for long-term job planning
- **Cost Analytics**: Automated total cost calculations for project planning
- **Performance Insights**: AI-powered job performance analysis and recommendations

## Technology Stack

- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: Bootstrap 5.3, Blade Templates, Font Awesome 6.4
- **Database**: MySQL with comprehensive administrative data
- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Laravel Policies for role-based access control
- **Real-time Features**: JavaScript for dynamic calculations and user interactions
- **Geographic Data**: Complete Rwanda administrative hierarchy integration

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd work-connect
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file and update database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=work_connect
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seed data**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Default Admin Account**
   - Email: `admin@gmail.com`
   - Password: `mstiles@123`
   - Admin Dashboard: `/admin`

6. **Populate administrative data (optional)**
   ```bash
   php artisan refresh:administrative-data
   ```

7. **Set up automatic job completion (optional)**
   Add to crontab for automatic job completion:
   ```bash
   0 2 * * * cd /path/to/work-connect && php artisan jobs:complete-expired
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Storage symlink (for image uploads)**
   ```bash
   php artisan storage:link
   ```

## Database Structure

### Core Tables

#### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `role` - Enum: 'worker', 'boss', or 'admin'
- `phone` - Contact phone number
- `document_url` - Optional URL to uploaded verification document
- `location` - General location description
- `category` - Worker category (laundry, builder, farmer, etc.)
- `other_category` - Custom category if 'other' selected
- `is_available` - Boolean availability status
- `daily_rate` - Worker's daily rate (for workers)
- `pickup_point_id` - Foreign key to pickup points
- `province_id`, `district_id`, `sector_id`, `cell_id`, `village_id` - Administrative location
- `is_suspended` - Boolean; suspended users cannot log in
- `is_verified` - Boolean; admin-verified worker document status
- `email_verified_at` - Email verification timestamp
- `created_at`, `updated_at` - Timestamps

#### Jobs Table
- `id` - Primary key
- `user_id` - Foreign key to users (employer)
- `title` - Job title
- `description` - Job description
- `category` - Job category
- `other_category` - Custom category if 'other' selected
- `location` - Job location
- `start_date`, `end_date` - Job date range
- `start_time`, `end_time` - Daily work hours
- `duration_days` - Total number of days
- `work_schedule` - JSON array of daily schedules (for multi-day jobs)
- `daily_rate` - Daily payment rate
- `status` - Enum: 'active', 'inactive', 'filled', 'completed'
- `pickup_point_id` - Designated pickup point
- `province_id`, `district_id`, `sector_id`, `cell_id`, `village_id` - Administrative location
- `created_at`, `updated_at` - Timestamps

#### Job Offers Table
- `id` - Primary key
- `job_id` - Foreign key to jobs
- `worker_id` - Foreign key to users (worker)
- `status` - Enum: 'pending', 'accepted', 'declined', 'completed'
- `accepted_at`, `declined_at`, `completed_at` - Status timestamps
- `rating` - Integer rating (1-5 stars) from employer
- `feedback` - Text feedback from employer
- `feedback_at` - Timestamp when feedback was given
- `created_at`, `updated_at` - Timestamps

#### Applications Table
- `id` - Primary key
- `job_id` - Foreign key to jobs
- `user_id` - Foreign key to users (applicant)
- `cover_letter` - Application cover letter
- `status` - Enum: 'pending', 'accepted', 'rejected'
- `created_at`, `updated_at` - Timestamps

### Administrative Tables
- `provinces` - Rwanda provinces
- `districts` - Districts within provinces
- `sectors` - Sectors within districts
- `cells` - Cells within sectors
- `villages` - Villages within cells
- `pickup_points` - Designated meeting locations

## Usage

### For Workers
1. **Registration**: Create account with role "worker"
2. **Profile Setup**: Set category, daily rate, and location preferences
3. **Availability**: Toggle availability status (requires location setup)
4. **Job Browsing**: Browse available jobs with location and category filters
5. **Applications**: Apply for jobs with cover letters
6. **Job Offers**: Receive and respond to job offers from employers
7. **Active Work**: View current job assignments and earnings
8. **Work History**: View completed jobs and employer feedback
9. **Performance Reviews**: See ratings and feedback from previous employers
10. **Status Tracking**: Monitor application and job offer status

### For Employers
1. **Registration**: Create account with role "boss"
2. **Job Creation**: Post jobs with date ranges, duration, and cost calculation
3. **Worker Selection**: Choose from available workers based on location and skills
4. **Job Offers**: Send offers to selected workers
5. **Active Management**: Monitor workers currently on jobs
6. **Worker Control**: Remove individual workers or end jobs early
7. **Job Completion**: End jobs and trigger feedback process
8. **Worker Feedback**: Rate and provide feedback for completed work
9. **Work History**: View completed jobs and manage feedback
10. **Performance Tracking**: View job statistics and worker performance
11. **Cost Management**: Track total project costs and budgets

## Key Features in Detail

### Multi-Day Job System
- **Date Range Selection**: Start and end dates for job duration
- **Automatic Duration Calculation**: System calculates total days automatically
- **Work Schedule Generation**: Detailed daily breakdown for multi-day jobs
- **Cost Transparency**: Real-time total cost calculation
- **Long-term Job Warnings**: Alerts for jobs longer than 7 days

### Worker Availability Intelligence
- **Active Job Detection**: Workers with accepted offers cannot become available
- **Smart Filtering**: Available workers list excludes those currently working
- **Clear Communication**: Workers see which jobs prevent availability
- **Automatic Release**: Workers become available when jobs complete

### Job Completion & Feedback System
- **Automatic Completion**: Jobs marked complete when end date passes
- **Manual Job Ending**: Employers can end jobs early and trigger feedback process
- **Worker Release**: All workers automatically released from completed jobs
- **Feedback Collection**: Employers prompted to rate workers after job completion
- **Rating System**: 5-star rating with detailed written feedback
- **Feedback Validation**: Only employers can give feedback for their own jobs
- **Status Tracking**: Complete audit trail of job lifecycle and feedback

### Geographic Integration
- **Administrative Hierarchy**: Complete Rwanda location structure
- **Location-Based Matching**: Workers matched by administrative location
- **Pickup Point System**: Designated meeting locations for coordination
- **Cascading Dropdowns**: Dynamic location selection in forms

## Commands

### Available Artisan Commands
```bash
# Populate administrative data
php artisan refresh:administrative-data

# Complete expired jobs
php artisan jobs:complete-expired

# List all commands
php artisan list

# Import Rwanda administrative data from external API
php artisan data:import-administrative --fresh
```

### ML Worker Ranking & Reputation (Flask)

Service location: `ml-service/`

Run locally:
```bash
cd ml-service
python -m venv .venv
. .venv/Scripts/activate  # Windows PowerShell: .venv\Scripts\Activate.ps1
pip install -r requirements.txt
python app.py  # starts on http://127.0.0.1:5000
```

Laravel config:
1. Set in `work-connect/.env`:
```env
ML_API_URL=http://127.0.0.1:5000
```
2. Example usage (Artisan):
```bash
php artisan ml:score-worker 123
```

API endpoints:
- `GET /health` → `{ ok: true, service: "worker-reputation", status: "healthy" }`
- `POST /score` → body:
```json
{
  "avg_rating": 4.6,
  "completed_jobs": 18,
  "is_verified": true,
  "completion_rate": 0.92,
  "num_reports": 1
}
```
Response:
```json
{
  "ok": true,
  "score": 89.7,
  "breakdown": {
    "rating_points": 46.0,
    "completed_points": 18.0,
    "verified_points": 15.0,
    "completion_points": 9.2,
    "report_penalty": 5.0
  }
}
```

### Training the Model (Daily)

- Laravel assembles training samples and calls the Flask `/train` endpoint.
- Command to trigger training manually:
```bash
php artisan ml:train-reputation
```
- Scheduler runs daily at 02:30 via `app/Console/Kernel.php`.

Training payload (sent by Laravel):
```json
{
  "samples": [
    {
      "avg_rating": 4.8,
      "completed_jobs": 22,
      "is_verified": true,
      "completion_rate": 0.95,
      "num_reports": 0,
      "target_score": 93.5
    }
  ]
}
```

### Employer Reports and Worker Warnings

- Employers can report workers from the Active Workers page. Reports include a reason and optional details.
- Admin reviews all reports in Admin → Reports, can change status, and send warnings to workers.
- Warnings are delivered to workers and appear on the Worker Dashboard. Once a worker views their dashboard, warnings are marked as read and automatically disappear 24 hours after being read.
- Each report decreases the worker reputation by 5 points in both the heuristic and ML-trained model (feature `num_reports`).

Setup/Usage:
1. Run DB migrations to create the warnings table:
```bash
php artisan migrate
```
2. Employer report form is available on Jobs → Active Workers (Report button per worker).
3. Admin panel → Reports shows: reporter name, reported worker, reason, details, status, and a “Warn Worker” button.

### New/Updated API Endpoints

- `GET /api/pickup-points/{village}` - Get pickup points for a village

These power the Settings page cascading selects and pickup point filtering by village.

### External Administrative API Configuration

Add these to your `.env`:

```env
ADMIN_API_URL=https://your-api.example.com
ADMIN_API_TOKEN=your_api_token
```

Usage:
- `php artisan data:import-administrative` will upsert provinces→villages.
- `--fresh` will truncate existing provinces, districts, sectors, cells, villages before import.

## File Structure

```
work-connect/
├── app/
│   ├── Console/Commands/
│   │   ├── CompleteExpiredJobs.php
│   │   └── RefreshAdministrativeData.php
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── JobController.php
│   │   ├── JobOfferController.php
│   │   ├── ApplicationController.php
│   │   ├── DashboardController.php
│   │   └── HistoryController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Job.php
│   │   ├── JobOffer.php
│   │   ├── Application.php
│   │   ├── Province.php
│   │   ├── District.php
│   │   ├── Sector.php
│   │   ├── Cell.php
│   │   ├── Village.php
│   │   └── PickupPoint.php
│   └── Policies/
│       ├── JobPolicy.php
│       ├── JobOfferPolicy.php
│       └── ApplicationPolicy.php
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_jobs_table.php
│   │   ├── create_job_offers_table.php
│   │   ├── create_applications_table.php
│   │   ├── create_administrative_tables.php
│   │   ├── add_date_range_to_jobs.php
│   │   └── add_feedback_fields_to_job_offers_table.php
│   └── seeders/
│       └── AdministrativeDataSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard/
│   │   ├── boss.blade.php
│   │   └── worker.blade.php
│   ├── jobs/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── my-jobs.blade.php
│   │   └── active-workers.blade.php
│   ├── job-offers/
│   │   ├── index.blade.php
│   │   └── job-offers.blade.php
│   ├── applications/
│   │   ├── index.blade.php
│   │   └── job-applications.blade.php
│   └── history/
│       ├── index.blade.php
│       └── feedback.blade.php
└── routes/
    └── web.php
```

## API Endpoints

### Administrative Data APIs
- `GET /api/provinces` - List all provinces
- `GET /api/districts/{province}` - Get districts for province
- `GET /api/sectors/{district}` - Get sectors for district
- `GET /api/cells/{sector}` - Get cells for sector
- `GET /api/villages/{cell}` - Get villages for cell

### Job Management APIs
- `GET /api/jobs/{job}/available-workers` - Get available workers for job
- `POST /api/jobs/{job}/send-offers` - Send job offers to workers

### History & Feedback APIs
- `GET /history` - View work history (completed jobs/offers)
- `GET /history/{jobOffer}/feedback` - Show feedback form for completed job
- `POST /history/{jobOffer}/feedback` - Submit feedback for completed job

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Future Enhancements

### Planned Features
- **Real-time Notifications**: Email and SMS notifications for job updates
- **Payment Integration**: Secure payment processing for completed jobs
- **Mobile Application**: React Native mobile app for workers and employers
- **Advanced Analytics**: Detailed performance metrics and insights
- **Interview Scheduling**: Built-in interview coordination system
- **Document Management**: Resume and certificate upload system
- **Advanced Search**: AI-powered job and worker search algorithms
- **API Development**: RESTful API for third-party integrations
- **Multi-language Support**: French and Kinyarwanda language support
- **Feedback Analytics**: Detailed feedback analysis and worker performance trends
- **Reputation System**: Worker reputation scores based on feedback history
- **Feedback Templates**: Pre-defined feedback templates for common job types

### Technical Improvements
- **Real AI Integration**: Machine learning for job matching
- **Performance Optimization**: Database indexing and query optimization
- **Security Enhancements**: Advanced authentication and authorization
- **Testing Suite**: Comprehensive unit and integration tests
- **CI/CD Pipeline**: Automated testing and deployment
- **Monitoring**: Application performance monitoring and logging

## Support

For support and questions, please contact the development team or create an issue in the repository.

---

**Work Connect** - Connecting talented workers with great opportunities through intelligent job matching and comprehensive project management.
