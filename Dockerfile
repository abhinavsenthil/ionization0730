# Use an official PHP runtime as the base image
FROM php:latest

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the PHP files to the container
COPY . /var/www/html

# Expose port 80 (assuming your PHP application runs on port 80)
EXPOSE 80

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:80"]
