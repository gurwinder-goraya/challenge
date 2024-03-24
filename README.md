**Service Catalogue CLI**

**Introduction:**
The Service Catalogue CLI is a command-line tool designed to query and summarize services provided by various research centers around the world. It reads data from a CSV file and allows users to query services based on country code or view a summary of services by country.

**Installation:**
1. Clone or download the repository.
2. composer install

**Usage:**
1. **Query Services:**

     php code.php query [COUNTRY_CODE]
     ```
   - Replace `[COUNTRY_CODE]` with the desired country code (e.g., FR for France).
   
2. **Summary:**
 
     php code.php summary
     ```

**Example:**
- To query services in France:
  ```
  php code.php query FR
  ```

**Notes:**
- Ensure the `services.csv` file is correctly formatted.
- If no services are found for a specific country code, an error message will be displayed.

**Contributing:**
- Feel free to fork the repository and submit pull requests with improvements or additional features.

**Author:**
- Gurwinder Singh