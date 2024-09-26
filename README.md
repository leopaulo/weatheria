# WEATHERIA

A comprehensive web-based application designed to provide accurate and up-to-date weather information for travelers exploring Japan.

---

# Tech Stack

-   PHP Laravel
-   VueJS
-   TailwindCSS
-   Redis
-   Docker

---

# UI/UX Considerations

This application prioritizes a clean, intuitive user experience:

-   Minimalist Design: A streamlined interface focuses on essential weather information.
-   Direct and Clear: Users can quickly access needed data without unnecessary clutter.
-   Enhanced Search Functionality: Quick links and autocomplete features expedite searches.
-   Google Maps link: Provides easy access to popular destinations.
-   Informative Loading Indicator: Keeps users updated on application progress.
-   Responsive Design: The application adapts seamlessly to various devices (CSS/TailwindCSS).
-   Performance Optimization: Vite-based asset bundling and Redis caching ensure rapid load times.
-   Efficient API Usage: Weather API calls are limited to one per city daily, while Foursquare API requests are restricted to one every five days. This strategy optimizes resource consumption and maintains performance.

---

# Coding Considerations

This application adheres to industry best practices for code quality and maintainability:

-   Framework and Library Adoption: Leveraging Laravel, Vue.js, and TailwindCSS provides a robust foundation for development.
-   Efficient Caching: Redis is employed to enhance performance and reduce server load.
-   Robust Backend Validation: Rigorous input validation ensures data integrity and security.
-   Standardized Response Format: Consistent API responses promote interoperability and ease of integration
-   Containerized Development: Docker containers provide a consistent development environment and enable automated unit testing during the build process.

---

# Local Setup Pre-requisite

-   Docker(Use WSL in Windows)
-   https://openweathermap.org/ API Key
-   https://docs.foursquare.com/ API key

---

# Local Setup

-   Clone Repository: Clone the project repository to your WSL distribution.
-   Initialize Docker: Run bash ./docker/init to set up the Docker environment.
-   Configure Environment Variables: Open the .env file and provide the following API keys:
    -   API_OWM_KEY: OpenWeatherMap API Key
    -   API_FS_KEY: Foursquare API Key
-   Start Application: Execute sail up --build to start the local environment.
-   Access Application: Open http://localhost:3080 in your web browser to access the application.

---

# Screenshots

![alt text](https://github.com/leopaulo/weatheria/blob/main/public/sample/homepage_desktop.png?raw=true)
![alt text](https://github.com/leopaulo/weatheria/blob/main/public/sample/homepage_mobile.png?raw=true)
![alt text](https://github.com/leopaulo/weatheria/blob/main/public/sample/search_desktop.png?raw=true)
![alt text](https://github.com/leopaulo/weatheria/blob/main/public/sample/search_mobile.png?raw=true)
