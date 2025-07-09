# 🔐 Smart Lock System using RFID & NodeMCU (ESP8266)

This project implements a **Smart Door Lock System** using **RFID (MFRC522)** and **NodeMCU ESP8266**, which authenticates users by scanning RFID cards and then logs the data to a **remote PHP server** over WiFi. If the card is authorized, it unlocks the door for a few seconds and logs the access online with a UID and user name.


## ✅ Features

- RFID-based authentication using MFRC522
- Door unlocking via relay/servo motor
- Real-time data logging to a PHP web server
- Serial monitor output for debugging
- Modular codebase with test files for WiFi and RFID
- Uses HTTP GET to send UID and username

---

## 🔧 Hardware Required

| Component             | Quantity |
|----------------------|----------|
| NodeMCU ESP8266      | 1        |
| MFRC522 RFID Module  | 1        |
| RFID Tags/Cards      | 1+       |
| Relay Module / Servo | 1        |
| Breadboard & Wires   | As needed |
| Power Supply (5V)    | 1        |
| Solenoid lock        | 1        |
| LCD Display          | 1        |

---

## 💻 Software Requirements

- [Arduino IDE](https://www.arduino.cc/en/software)
- ESP8266 Board Package (via Board Manager)
- PHP-enabled hosting (e.g., [000webhost](https://www.000webhost.com/))

---

## 📦 Library Installation

Go to **Arduino IDE > Tools > Manage Libraries** and install the following:

- `ESP8266WiFi`
- `ESP8266HTTPClient`
- `MFRC522`
- `SPI`



## 🗂️ Project Structure

```plaintext
smart-lock-rfid/
├── main_code.ino       → Full implementation
├── wifi_test.ino       → Checks WiFi connectivity
├── rfid_test.ino       → Reads and prints RFID UIDs
└── add_rfid_data.php   → Backend script to log data online (to be hosted)




```

---

> ⚠️ **Caution**
>
> Make sure to replace the following lines in your code with **your actual WiFi credentials**:
>
> ```cpp
> #define ssid "wifi_name"
> #define password "wifi_password"
> ```
>
> If you do not update these, your NodeMCU will **fail to connect to WiFi**, and the system will not work.
>
> ✅ Use your mobile hotspot or router SSID and password that your NodeMCU can access.


---

### 🌐 Configuring the Server URL

In your code, update the following line with your **actual web hosting domain**:

```cpp
String URL = "https://yourwebsitehostingdomain/add_rfid_data.php";
```

Use a valid and publicly accessible hosting provider such as **000webhost**, **InfinityFree**, or **Hostinger**.  
Make sure the hosting service supports **PHP**.

You need to upload the following PHP files to your hosting account, specifically inside the `public_html` or root directory:

- **`add_rfid_data.php`**: This script handles saving the scanned RFID card UID and the associated user name.
- **`show_rfid_data.php`**: This script displays the saved RFID data in a tabular format for easy viewing.

After uploading the files, verify the setup by opening a browser and visiting the following test URL:

```cpp
https://yourwebsitehostingdomain/add_rfid_data.php?carduid=123456&name=Test
```

If everything is set up correctly, you should see a confirmation message like:

```cpp
Data Saved Successfully
```

---

### 📌 MySQL Table Structure (for reference)

Run the following SQL query in **phpMyAdmin** to create the required table in your database:

```sql
CREATE TABLE rfid_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carduid VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

This table will store:

- **`id`**: Unique identifier for each entry (auto-incremented primary key)
- **`carduid`**: The UID of the scanned RFID card
- **`name`**: The associated user name
- **`timestamp`**: The exact date and time when the card was scanned (defaults to current time)


---

### 📋 Access Log

After uploading the `show_rfid_data.php` file to your hosting provider, you can view the recorded RFID access logs in a clean table format.

**Access it via:**

```cpp
https://yourwebsitehostingdomain/show_rfid_data.php
```

