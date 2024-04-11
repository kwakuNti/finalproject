-- Create Users table
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    country VARCHAR(50) NOT NULL,
    profile_picture VARCHAR(200)
);

-- Create Admins table
CREATE TABLE Admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL
);

-- Create Destinations table
CREATE TABLE Destinations (
    destination_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(50) NOT NULL,
    description TEXT,
    image_url VARCHAR(200)
);

-- Create Flights table
CREATE TABLE Flights (
    flight_id INT AUTO_INCREMENT PRIMARY KEY,
    flight_code VARCHAR(10) UNIQUE NOT NULL,
    origin_destination_id INT NOT NULL,
    destination_destination_id INT NOT NULL,
    departure_datetime DATETIME NOT NULL,
    arrival_datetime DATETIME NOT NULL,
    duration TIME NOT NULL,
    stops INT NOT NULL,
    economy_seats INT NOT NULL,
    business_seats INT NOT NULL,
    first_seats INT NOT NULL,
    CONSTRAINT fk_origin_destination FOREIGN KEY (origin_destination_id) REFERENCES Destinations(destination_id),
    CONSTRAINT fk_destination_destination FOREIGN KEY (destination_destination_id) REFERENCES Destinations(destination_id),
    CONSTRAINT check_departure_arrival CHECK (departure_datetime < arrival_datetime),
    CONSTRAINT check_seats CHECK (economy_seats + business_seats + first_seats > 0)
);

-- Create Bookings table
CREATE TABLE Bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    booking_date DATE NOT NULL,
    class ENUM('Economy', 'Business', 'First') NOT NULL,
    passengers INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES Users(user_id),
    CONSTRAINT fk_flight FOREIGN KEY (flight_id) REFERENCES Flights(flight_id),
    CONSTRAINT check_passengers CHECK (passengers > 0)
);

-- Create Payments table
CREATE TABLE Payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT UNIQUE NOT NULL,
    card_number VARCHAR(20) NOT NULL,
    expiry_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_booking FOREIGN KEY (booking_id) REFERENCES Bookings(booking_id),
    CONSTRAINT check_amount CHECK (amount > 0)
);

-- Create Schedules table
CREATE TABLE Schedules (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    booking_id INT NOT NULL,
    CONSTRAINT fk_user_schedule FOREIGN KEY (user_id) REFERENCES Users(user_id),
    CONSTRAINT fk_booking_schedule FOREIGN KEY (booking_id) REFERENCES Bookings(booking_id)
);

CREATE TABLE Prices (
    price_id INT AUTO_INCREMENT PRIMARY KEY,
    destination_id INT NOT NULL,
    class ENUM('Economy', 'Business', 'First') NOT NULL,
    season ENUM('Low', 'High') NOT NULL,
    base_price DECIMAL(10, 2) NOT NULL,
    CONSTRAINT fk_destination FOREIGN KEY (destination_id) REFERENCES Destinations(destination_id)
);
INSERT INTO Destinations (name, country, description, image_url) VALUES
    ('Paris', 'France', 'The City of Love, known for its iconic Eiffel Tower, art museums, and café culture.', 'https://wallup.net/wp-content/uploads/2019/10/538617-architecture-cities-france-light-towers-monuments-night-panorama-panoramic-paris-urban-temples.jpg'),
    ('Rome', 'Italy', 'The Eternal City, home to ancient Roman ruins, the Vatican City, and delicious Italian cuisine.', 'https://www.tripsavvy.com/thmb/u28osDPT6pxj9YP14cEMyFgxmC0=/3864x2576/filters:fill(auto,1)/st-peter-s-basilica--the-vatican--river-tiber--rome--italy-938308692-5c02f9a446e0fb000184fce4.jpg'),
    ('Bali', 'Indonesia', 'A tropical paradise with beautiful beaches, lush rice fields, and rich cultural traditions.', 'https://th.bing.com/th/id/R.1e01e8dd86c6200ebd7aff4148e41244?rik=CE9jWwe3wxAuKQ&pid=ImgRaw&r=0'),
    ('Dubai', 'United Arab Emirates', 'A modern city with stunning architecture, luxury shopping, and thrilling desert adventures.', 'https://process.filestackapi.com/resize=fit:clip,width:1440,height:720/quality=v:79/compress/cache=expiry:604800/Z4qmabWpTwCEqXTfDH9i'),
    ('Tokyo', 'Japan', 'A vibrant metropolis that seamlessly blends tradition and modernity, with incredible cuisine and pop culture.', 'https://th.bing.com/th/id/R.d0c3f79952bc6066f1a5ea574c98fc5a?rik=Q5qDE9ODKv7wLA&pid=ImgRaw&r=0'),
    ('New York City', 'United States', 'The Big Apple, a bustling city with iconic landmarks, world-class museums, and diverse neighborhoods.', 'https://th.bing.com/th/id/R.4b627e2b5e07038ae92a984f613c65c9?rik=XPrvjvaed%2fTxKQ&pid=ImgRaw&r=0'),
    ('Sydney', 'Australia', 'A cosmopolitan city with a stunning harbor, beaches, and iconic Sydney Opera House.', 'https://th.bing.com/th/id/R.c7e388463eac7817b026847ebfe9cad7?rik=mBg9pWOeFo88SQ&pid=ImgRaw&r=0'),
    ('Barcelona', 'Spain', 'A vibrant city with incredible architecture, lively nightlife, and delicious tapas.', 'https://www.tripsavvy.com/thmb/8VKOZbYhKRecUgdgmwfKsFlw2f8=/4208x2366/filters:fill(auto,1)/spain--barcelona--panoramic-view-of-barcelona-cathedral-735895859-599aedf7685fbe0010120fc1.jpg'),
    ('London', 'United Kingdom', 'A historic city with royal palaces, iconic landmarks, and a vibrant cultural scene.', 'https://wallup.net/wp-content/uploads/2019/09/893067-united-kingdom-houses-rivers-bridges-sunrises-and-sunsets-england-london-megapolis-from-above-cities-1.jpg'),
    ('Santorini', 'Greece', 'A picturesque island with whitewashed buildings, breathtaking sunsets, and stunning caldera views.', 'https://th.bing.com/th/id/OIP.6ZPNYVzwWsu6ck4DZoTx8AHaE7?rs=1&pid=ImgDetMain'),
    ('Marrakech', 'Morocco', 'A vibrant city with a rich history, bustling souks, and stunning Moorish architecture.', 'https://th.bing.com/th/id/R.43a492bfefa361a7f8cd6e6358d1e245?rik=%2bokVAyNt75vWcQ&pid=ImgRaw&r=0'),
    ('Rio de Janeiro', 'Brazil', 'A lively city with iconic landmarks like Christ the Redeemer, beautiful beaches, and vibrant nightlife.', 'https://th.bing.com/th/id/R.9d212d4b95619492238690980b9ddfea?rik=je5PvQ9%2fZQy7hg&pid=ImgRaw&r=0'),
    ('Cape Town', 'South Africa', 'A stunning city with Table Mountain, beautiful beaches, and a rich cultural heritage.', 'https://th.bing.com/th/id/R.64246bcd0e553f91d2fc173604149b61?rik=5ADQfnVYF5KBjQ&pid=ImgRaw&r=0'),
    ('Queenstown', 'New Zealand', 'An adventure capital with breathtaking landscapes, outdoor activities, and a lively town center.', 'https://th.bing.com/th/id/R.d7a1243e583936c8f386c53ddca2cf1d?rik=1F%2fxuIGPsyGHFA&pid=ImgRaw&r=0'),
    ('Chiang Mai', 'Thailand', 'A vibrant city with ancient temples, delicious street food, and a rich cultural heritage.', 'https://media.timeout.com/images/105240238/image.jpg'),
    ('Havana', 'Cuba', 'A historic city with colorful colonial architecture, classic cars, and a lively music scene.', 'https://th.bing.com/th/id/R.63f054affee05ec5e74525148b385a17?rik=TMjuTDLNOYdO4A&pid=ImgRaw&r=0'),
    ('Reykjavik', 'Iceland', 'A unique city with stunning natural landscapes, geothermal pools, and the chance to see the Northern Lights.', 'https://th.bing.com/th/id/R.619f46b118065b7a6c9c7500911235b3?rik=%2bF7TyzPTQIWcnQ&pid=ImgRaw&r=0'),
    ('Cusco', 'Peru', 'A historic city and gateway to the ancient Inca ruins of Machu Picchu.', 'https://a.travel-assets.com/findyours-php/viewfinder/images/res70/66000/66587-Cusco.jpg'),
    ('Hanoi', 'Vietnam', 'A vibrant city with a rich cultural heritage, delicious street food, and charming colonial architecture.', 'https://cdn.urlaubsguru.at/wp-content/uploads/2019/07/shutterstock_749778241.jpg'),
    ('Siem Reap', 'Cambodia', 'A gateway to the ancient Angkor Wat temple complex and a bustling city with a lively nightlife.', 'https://topplacetovisit.com/wp-content/uploads/ta-prohm-siem-reap-cambodia.jpg');


INSERT INTO Prices (destination_id, class, season, base_price) VALUES
    (1, 'Economy', 'Low', 800.00),
    (1, 'Economy', 'High', 1000.00),
    (1, 'Business', 'Low', 1500.00),
    (1, 'Business', 'High', 1800.00),
    (1, 'First', 'Low', 2500.00),
    (1, 'First', 'High', 3000.00),

    (2, 'Economy', 'Low', 900.00),
    (2, 'Economy', 'High', 1100.00),
    (2, 'Business', 'Low', 1600.00),
    (2, 'Business', 'High', 1900.00),
    (2, 'First', 'Low', 2700.00),
    (2, 'First', 'High', 3200.00),

    (3, 'Economy', 'Low', 1200.00),
    (3, 'Economy', 'High', 1400.00),
    (3, 'Business', 'Low', 2000.00),
    (3, 'Business', 'High', 2300.00),
    (3, 'First', 'Low', 3500.00),
    (3, 'First', 'High', 4000.00),

    (4, 'Economy', 'Low', 1000.00),
    (4, 'Economy', 'High', 1200.00),
    (4, 'Business', 'Low', 1800.00),
    (4, 'Business', 'High', 2100.00),
    (4, 'First', 'Low', 3000.00),
    (4, 'First', 'High', 3500.00),

    (5, 'Economy', 'Low', 1100.00),
    (5, 'Economy', 'High', 1300.00),
    (5, 'Business', 'Low', 1900.00),
    (5, 'Business', 'High', 2200.00),
    (5, 'First', 'Low', 3200.00),
    (5, 'First', 'High', 3700.00),

    (6, 'Economy', 'Low', 700.00),
    (6, 'Economy', 'High', 900.00),
    (6, 'Business', 'Low', 1400.00),
    (6, 'Business', 'High', 1700.00),
    (6, 'First', 'Low', 2400.00),
    (6, 'First', 'High', 2900.00),

    (7, 'Economy', 'Low', 1300.00),
    (7, 'Economy', 'High', 1500.00),
    (7, 'Business', 'Low', 2100.00),
    (7, 'Business', 'High', 2400.00),
    (7, 'First', 'Low', 3600.00),
    (7, 'First', 'High', 4100.00),

    (8, 'Economy', 'Low', 900.00),
    (8, 'Economy', 'High', 1100.00),
    (8, 'Business', 'Low', 1600.00),
    (8, 'Business', 'High', 1900.00),
    (8, 'First', 'Low', 2700.00),
    (8, 'First', 'High', 3200.00),

    (9, 'Economy', 'Low', 800.00),
    (9, 'Economy', 'High', 1000.00),
    (9, 'Business', 'Low', 1500.00),
    (9, 'Business', 'High', 1800.00),
    (9, 'First', 'Low', 2500.00),
    (9, 'First', 'High', 3000.00),

    (10, 'Economy', 'Low', 1100.00),
    (10, 'Economy', 'High', 1300.00),
    (10, 'Business', 'Low', 1900.00),
    (10, 'Business', 'High', 2200.00),
    (10, 'First', 'Low', 3200.00),
    (10, 'First', 'High', 3700.00),

    (11, 'Economy', 'Low', 1200.00),
    (11, 'Economy', 'High', 1400.00),
    (11, 'Business', 'Low', 2000.00),
    (11, 'Business', 'High', 2300.00),
    (11, 'First', 'Low', 3500.00),
    (11, 'First', 'High', 4000.00),

    (12, 'Economy', 'Low', 1000.00),
    (12, 'Economy', 'High', 1200.00),
    (12, 'Business', 'Low', 1800.00),
    (12, 'Business', 'High', 2100.00),
    (12, 'First', 'Low', 3000.00),
    (12, 'First', 'High', 3500.00),

    (13, 'Economy', 'Low', 1300.00),
    (13, 'Economy', 'High', 1500.00),
    (13, 'Business', 'Low', 2100.00),
    (13, 'Business', 'High', 2400.00),
    (13, 'First', 'Low', 3600.00),
    (13, 'First', 'High', 4100.00),

    (14, 'Economy', 'Low', 1400.00),
    (14, 'Economy', 'High', 1600.00),
    (14, 'Business', 'Low', 2200.00),
    (14, 'Business', 'High', 2500.00),
    (14, 'First', 'Low', 3800.00),
    (14, 'First', 'High', 4300.00),

    (15, 'Economy', 'Low', 1200.00),
    (15, 'Economy', 'High', 1400.00),
    (15, 'Business', 'Low', 2000.00),
    (15, 'Business', 'High', 2300.00),
    (15, 'First', 'Low', 3500.00),
    (15, 'First', 'High', 4000.00),

    (16, 'Economy', 'Low', 1100.00),
    (16, 'Economy', 'High', 1300.00),
    (16, 'Business', 'Low', 1900.00),
    (16, 'Business', 'High', 2200.00),
    (16, 'First', 'Low', 3200.00),
    (16, 'First', 'High', 3700.00),

    (17, 'Economy', 'Low', 1300.00),
    (17, 'Economy', 'High', 1500.00),
    (17, 'Business', 'Low', 2100.00),
    (17, 'Business', 'High', 2400.00),
    (17, 'First', 'Low', 3600.00),
    (17, 'First', 'High', 4100.00),

    (18, 'Economy', 'Low', 1400.00),
    (18, 'Economy', 'High', 1600.00),
    (18, 'Business', 'Low', 2200.00),
    (18, 'Business', 'High', 2500.00),
    (18, 'First', 'Low', 3800.00),
    (18, 'First', 'High', 4300.00),
    (19, 'Economy', 'Low', 1200.00),
    (19, 'Economy', 'High', 1400.00),
    (19, 'Business', 'Low', 2000.00),
    (19, 'Business', 'High', 2300.00),
    (19, 'First', 'Low', 3500.00),
    (19, 'First', 'High', 4000.00),

    (20, 'Economy', 'Low', 1300.00),
    (20, 'Economy', 'High', 1500.00),
    (20, 'Business', 'Low', 2100.00),
    (20, 'Business', 'High', 2400.00),
    (20, 'First', 'Low', 3600.00),
    (20, 'First', 'High', 4100.00);

-- Insert default destinations

-- Drop the Admins table
DROP TABLE Admins;

-- Alter the Users table to add a role column
ALTER TABLE Users
ADD COLUMN role_id INT NOT NULL;

-- Create the Roles table
CREATE TABLE Roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL,
    description TEXT
);

-- Insert default roles
INSERT INTO Roles (role_name, description) VALUES
    ('Admin', 'System administrators with full access'),
    ('User', 'Regular users with limited access');

-- Add a foreign key constraint to the Users table
ALTER TABLE Users
ADD CONSTRAINT fk_user_role
FOREIGN KEY (role_id) REFERENCES Roles(role_id);


ALTER TABLE Users
ADD account_activation_hash VARCHAR(64) NULL DEFAULT NULL AFTER role_id,
ADD UNIQUE (account_activation_hash);
