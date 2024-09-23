# Innout

**Innout** is a simple system designed to help employees clock in and out during work hours. The application allows employees to easily log their entry and exit times and helps administrators track work hours efficiently.

This project was developed using PHP and MySQL for the backend, and HTML, CSS (Bootstrap), and JavaScript for the frontend. It follows the MVC (Model-View-Controller) architectural pattern, and it is containerized using Docker for easy setup and deployment.

![alt text](https://github.com/guilhermedesousa/innout/blob/main/public/assets/img/innout-dash-screenshot.png)

## Table of Contents
- [Features](#features)
- [Installation](#installation)

## Features

- Employee clock in/out functionality
- Worked and exit time tracking
- Monthly report view
- Manager report (only for admins)
- User-friendly interface
- Separation of concerns using the MVC pattern
- Dockerized for easy local development and deployment

## Installation

### Prerequisites
- Docker
- Docker Compose

### Setup

1. Clone the repository

```bash
git clone https://github.com/guilhermedesousa/innout
cd innout
```

2. Build and start the Docker containers:

```bash
docker compose up --build
```

3. Access the application

- The application will be accessible at `http://localhost:8080`
- The MySQL database will be accessible at `http://localhost:8001` 

### Environment Variables
Make sure to configure environment variables for your MySQL database in `docker-compose.yml`:

```yaml
MYSQL_ROOT_PASSWORD: rootpassword
MYSQL_DATABASE: innout
MYSQL_USER: user
MYSQL_PASSWORD: password
```

After that, set the same variables in `env.ini`:

```ini
host = ""
username = ""
password = ""
database = ""
```