
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

 


# Dynamic Form Workflow & Content Management System

## Live Demo

**Live URL:** https://workflow.mongutech.com/



**GitHub Repository:** https://github.com/CLON6969/workflow


## Test User Credentials

The system includes pre-configured test accounts for evaluation purposes. (both in live and seeding localsetup or you can create your own)

### Reviewer / Administrator Account

**Role:** Reviewer (Admin)

**Email:** mongutechnologies@gmail.com

**Username:** Reviewer

**Password:** password

**Permissions:**



### Applicant Account

**Role:** Applicant

**Email:** erickmaliko69@gmail.com

**Username:** Applicant

**Password:** password

**Permissions:**

### Workflow Testing Steps

1. Login as the Applicant.
2. Create a new application and save it as a draft.
3. Submit the application.
4. Logout and login as the Reviewer.
5. Review the submitted application.
6. Approve, Reject, or Return the application for changes.
7. If returned, login again as the Applicant.
8. Edit the application and resubmit it.
9. Verify the workflow audit trail in the Application Logs.

> Note: These credentials are intended for testing and demonstration purposes only.

---





# Project Overview

This project is a Laravel 12 web application developed as a solution for the Dynamic Form Builder and Submission & Approval Workflow assignment.

The system provides a complete application submission workflow where applicants can create, edit, submit, and track applications while reviewers manage approvals through a controlled workflow engine with a full audit trail.

In addition to the workflow functionality, the platform includes a dynamic content management component that allows administrators (reviewers) to manage website content directly from the dashboard without modifying source code.(this includes , navlinks ,landing pange, foooter, aboutpage and manymore) 

futher more , it also has account management both for the applicant and the Reviewer

futher more a logingin feature using google and facebook has been added

---

# Assignment Objectives Covered

## Assignment A: Dynamic Form Builder Engine

The system provides a configurable foundation for managing and processing application forms.

Features include:

* Dynamic application creation
* Form validation
* File attachment support
* Structured application storage
* Category-based application management
* Extensible architecture for future dynamic form definitions

---

## Assignment B: Submission & Approval Workflow

The system implements a complete workflow process with enforced status transitions and audit logging.

Workflow states include:

* Draft
* Under Review
* Approved
* Rejected
* Returned for Changes

Every status change is validated through a centralized workflow service to ensure workflow integrity.

---

# Core Features

## Authentication & Authorization

* Laravel Authentication (loingin and signup)
* Role-Based Access Control
* Applicant Role
* Reviewer Role
* Policy-Based Authorization
* Protected Workflow Actions

---

## Applicant Features

Applicants can:

* Register and log in
* Create application drafts
* Edit drafts
* Upload supporting documents
* Submit applications
* View application history
* Track application status
* Receive reviewer feedback
* Edit returned applications
* Re-submit returned applications

---

## Reviewer Features

Reviewers can:

* View review queues
* Review submitted applications
* Approve applications
* Reject applications
* Return applications for corrections
* Add review comments
* Track workflow history
* Monitor user activities

---

# Website Content Management

A unique aspect of this system is its integrated content management capability.

The Reviewer (Administrator) can dynamically manage website content through the dashboard without accessing source code.

Manageable sections include:

* Navigation Links
* Landing Page Content
* Hero Sections
* About Page
* Footer Content
* Opportunities Section
* Informational Pages
* Dynamic Website Text and Media
* Website Images and Visual Assets

This functionality allows the website to serve both as a workflow management platform and a content-managed web application.

---

# Workflow Architecture

The application uses a centralized workflow(workflow management only without the website managment) engine implemented through:

## ApplicationWorkflowService

All status changes are processed through a single service layer.

This ensures:

* Workflow consistency
* Transition validation
* Audit logging
* Permission enforcement
* Business rule management

---

## Workflow Diagram

Draft

↓

Under Review (this is the same as submitting a draft for review)

├── Approved

├── Rejected

└── Returned For Changes

↓

Applicant Updates

↓

Re-Submit

↓

Under Review

---

# Audit Trail

Every workflow action is recorded.

The system logs:

* User performing the action
* Previous status
* New status
* Review comments
* Date and time

All audit records are stored in the `application_logs` table.

This provides complete traceability of every application.

---

# Database Structure

## Main Tables

### users

Stores system users and authentication details.

### roles

Stores user roles and permissions. (but has been simplified to id and name(that is wat i just utilized))

### applications

Stores submitted applications and workflow information.

### application_logs




### Other table are resposible for managing website content dynamically
Tables such as (About, home, nav1, footer and many more)


these tables Store additional informational content blocks.

Additional CMS-related tables are used to manage website content dynamically.

---

# Technologies Used

## Backend

* Laravel 12
* PHP 8.3
* MySQL

## Frontend

* Blade Templates
* Tailwind CSS
* JavaScript
* AOS Animations

## Development Tools

* Composer
* NPM
* Git
* GitHub

---

# Installation Guide

## Clone Repository

```bash
git clone https://github.com/CLON6969/workflow.git   

  (puth the folder(workflow) in www if you are using laragon or put it in hotdocs if you are using xamp)
cd workflow
```

## Install Dependencies

```bash
composer install
npm install
```

## Environment Configuration

Copy the environment file:

```bash
cp .env.example .env
```


```bash
php artisan key:generate
```

Update database credentials in `.env`.
## ------------------------ ##
## database cridensials      ##
## ------------------------ ##

## DB_CONNECTION=mysql
## DB_HOST=127.0.0.1
## DB_PORT=3306
## DB_DATABASE=workflow
## DB_USERNAME=root
## DB_PASSWORD=
## Generate application key:
---

## Run Migrations

```bash
php artisan migrate
```

---

## Run Seeders

```bash
php artisan db:seed
```

---

## Storage Link 

```bash
php artisan storage:link
```

---

## Build Frontend Assets (to fully complete the setup)

```bash
npm run build
```

---

## Start Application

Open in Web Browser

Open your browser and navigate to: (http://localhost/workflow/)

---

# Design Decisions

Several architectural decisions were made during development:

### Centralized Workflow Logic

Instead of allowing controllers to directly change statuses, all workflow transitions are managed through a dedicated service layer.

Benefits:

* Single source of truth
* Easier maintenance
* Better scalability
* Reduced duplication

### Policy-Based Authorization

Laravel Policies were used to ensure that permissions are enforced consistently throughout the application.

### Audit Logging

Every workflow transition is logged to provide accountability and transparency.

---

# Testing

The following workflow scenarios were tested:(manual testing was used)

* Draft Creation
* Draft Editing
* Application Submission
* Review Queue Processing
* Approval Workflow
* Rejection Workflow
* Return for Changes Workflow
* Re-Submission Workflow
* Audit Logging
* Authorization Policies

---

# Use of AI Assistance

During development, ChatGPT and Grock was used as a supplementary development tool to assist with:


* Workflow design refinement
* Debugging and troubleshooting
* Code review and optimization suggestions
* Database design guidance
* README documentation preparation

All implementation decisions, testing, integration, customization, and final code validation were performed by the developer.

AI assistance was used in a similar capacity to technical documentation, online references, and developer resources.

---

# Future Improvements

Future enhancements may include:


* Multi-Level Approval Chains
* Email Notifications
* SMS Notifications
* Dashboard Analytics
* Reviewer Assignment Automation
* Advanced Reporting
* Export to PDF and Excel
* REST API Integration

---

# Author

**Erick Maliko**

Laravel 12 Workflow & Content Management System

Developed as part of the Dynamic Form Builder and Submission & Approval Workflow assignment.

