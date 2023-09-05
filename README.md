# Collaborative Whiteboard / Drawing App

## Introduction
This project is a PHP-based collaborative whiteboard application that enables multiple users to draw on a shared canvas, with their drawings synchronized across clients in near real-time using XHR polling. The app leverages HTML5 Canvas for rendering, JavaScript for client-side interaction, and PHP for server-side data storage and retrieval. It generates an XML file to share drawing data, making it accessible and lightweight for small-scale collaborative environments.

## Purpose
The purpose of this project is to provide a simple, web-based tool for real-time collaborative drawing, suitable for brainstorming, teaching, or casual sketching. It demonstrates fundamental concepts of real-time web applications using a polling-based approach, avoiding the complexity of WebSockets. The app is ideal for educational settings, remote collaboration, or prototyping real-time systems with minimal dependencies.

## How It Works
The workflow for the collaborative whiteboard is as follows:
1. **User Draws**: A user draws a line segment on their canvas using mouse or touch input. The client-side JavaScript (`whiteboard.js`) captures the coordinates (start and end points), color, and thickness of the segment.
2. **Data Submission**: The coordinates are sent to a PHP script (`save_drawing.php`) via an XHR POST request in JSON format.
3. **Server Storage**: The `save_drawing.php` script validates the input and stores the coordinates in a MySQL database.
4. **Data Retrieval**: Another PHP script (`get_drawings.php`) retrieves all stored coordinates from the database and generates an XML file (`drawings.xml`) containing the drawing data.
5. **Client Polling**: Each client periodically fetches the `drawings.xml` file via XHR (e.g., every 1 second) to get the latest drawing updates.
6. **Canvas Rendering**: The client-side JavaScript parses the XML file and redraws all line segments on the canvas, ensuring all users see the same drawing.

The polling interval (set to 1 second by default) determines the near real-time responsiveness of the collaboration.

## Project Directory Structure
```
/project-root
├── /config
│   └── database.php          # Database configuration (connection settings)
├── /includes
│   └── db_connect.php       # Database connection logic
├── /data
│   └── drawings.xml         # Generated XML file for drawing coordinates
├── /js
│   └── whiteboard.js        # Client-side JavaScript for canvas drawing and XHR
├── index.html               # Main HTML file with canvas
├── save_drawing.php         # Saves drawing coordinates to database
├── get_drawings.php         # Generates XML file from database
├── .env                     # Environment variables (e.g., DB credentials)
├── .htaccess               # Security rules to restrict direct access to data and config
└── README.md               # Project documentation
```

## Requirements
### Server
- **PHP**: 8.1 or higher with `pdo_mysql` and `xmlwriter` extensions
- **Web Server**: Apache (with `.htaccess` support) or Nginx
- **Database**: MySQL 5.7 or higher (or MariaDB)
- **File System**: Writable `/data` directory for storing `drawings.xml`

### Database Schema
- **Table**: `drawings`
  - `id` (INT, PRIMARY KEY, AUTO_INCREMENT): Unique drawing segment ID
  - `start_x` (FLOAT): X-coordinate of the line segment's start point
  - `start_y` (FLOAT): Y-coordinate of the line segment's start point
  - `end_x` (FLOAT): X-coordinate of the line segment's end point
  - `end_y` (FLOAT): Y-coordinate of the line segment's end point
  - `color` (VARCHAR): Line color (e.g., "#FF0000" for red)
  - `thickness` (FLOAT): Line thickness (e.g., 2.0)
  - `created_at` (TIMESTAMP): Time the segment was drawn

### Dependencies
- **Optional**: `vlucas/phpdotenv` for environment variable management
  - Install via Composer: `composer require vlucas/phpdotenv`

## Setup Instructions
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo
   ```

2. **Install Dependencies** (if using phpdotenv):
   ```bash
   composer install
   ```

3. **Set Up the Database**:
   - Create a MySQL database (e.g., `whiteboard`).
   - Create the `drawings` table with the schema:
     ```sql
     CREATE TABLE drawings (
         id INT AUTO_INCREMENT PRIMARY KEY,
         start_x FLOAT NOT NULL,
         start_y FLOAT NOT NULL,
         end_x FLOAT NOT NULL,
         end_y FLOAT NOT NULL,
         color VARCHAR(7) NOT NULL,
         thickness FLOAT NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
     ```

4. **Configure Environment**:
   - Copy `.env.example` to `.env` and update with your database credentials:
     ```
     DB_HOST=localhost
     DB_NAME=whiteboard
     DB_USER=root
     DB_PASS=your_password
     ```

5. **Set Up Data Directory**:
   - Create the `/data` directory with write permissions:
     ```bash
     mkdir -p data
     chmod 755 data
     ```

6. **Secure Directories**:
   - Place an `.htaccess` file in `/data` and `/config` with:
     ```
     Deny from all
     ```
   - For Nginx, add equivalent rules (e.g., `deny all;`) in the server configuration.

7. **Test the System**:
   - Deploy the project to a web server.
   - Open `index.html` in multiple browser windows.
   - Draw in one window and verify that the drawings appear in others within 1-2 seconds.

## Security Considerations
- **File Access**: The `.htaccess` file in `/data` and `/config` prevents direct access to `drawings.xml` and `database.php`.
- **Input Validation**: The `save_drawing.php` script validates incoming JSON data to prevent malformed or malicious inputs.
- **SQL Injection**: Uses PDO prepared statements to sanitize database inputs.
- **HTTPS**: Deploy over HTTPS to secure XHR requests and responses.
- **Rate Limiting**: Consider implementing server-side rate limiting to prevent excessive polling or data submission.
- **Data Cleanup**: Periodically truncate the `drawings` table to manage database size, as the app continuously stores new segments.

## Additional Notes
- **Polling Interval**: The 1-second polling interval in `whiteboard.js` balances responsiveness and server load. Adjust the `setInterval` value for different performance needs.
- **Scalability**: For larger-scale use, consider switching to WebSockets (e.g., via Ratchet for PHP) to reduce polling overhead.
- **Enhancements**: Add features like user authentication, color/thickness selection, or canvas clearing for a production-ready app.
- **Error Handling**: The app includes basic error handling (e.g., invalid input, database errors). Enhance with user-friendly messages for production.
- **Testing**: Test with multiple clients and various input scenarios (e.g., rapid drawing, simultaneous users) to ensure synchronization.

## Contributing
Contributions are welcome! Please submit issues or pull requests via GitHub. Ensure code follows PSR-12 standards for PHP and includes appropriate comments for clarity.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.<!-- Add initial project documentation in README.md -->
<!-- Update README with setup instructions -->
<!-- Document export feature in README.md -->
<!-- Finalize README with usage examples -->
<!-- Add initial project documentation in README.md -->
