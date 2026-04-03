# Simple Small Business Asset (Sbiz-Asset)

## Introduction

Managing physical assets is a critical challenge for growing businesses. Without a proper system, tracking furniture, electronics, and specialized equipment often leads to data loss, missing items, and inaccurate financial records. 

**Simple Small Business Asset (Sbiz-Asset)** is an **Open Source** initiative and a comprehensive management solution. It is designed to help organizations move away from manual spreadsheets and towards a professional process that prevents asset loss and eliminates wasteful duplicate spending. Open for anyone to use, modify, and develop, the system is available for free under the MIT License to support better asset governance worldwide.

---

## 📄 License

This project is licensed under the **MIT License**. You are free to use, modify, and distribute this software for personal or commercial purposes. See the [LICENSE](file:///d:/mygithub-research/opensource-product/sbiz-asset/LICENSE) file for more details.

---

## 1. Business Purpose and Benefits

**Sbiz-Asset** helps businesses stay organized by providing a central place to record all fixed assets (furniture, electronics, machinery, etc.). 

*   **Financial Clarity**: Track asset values, acquisition costs, and current net values after depreciation.
*   **Asset Auditing**: Easily track where each asset is located and which department is responsible for it.
*   **Cost Efficiency & Loss Prevention**: Maintain high accuracy of asset data to prevent theft, loss, or misplacement. Identifying missing assets early saves significant replacement costs.
*   **Maintenance & Protection**: Manage repair logs and maintenance history to extend the life of your assets and prevent costly equipment failures.
*   **Strategic Planning**: Detailed reports help in planning future equipment purchases and budgeting based on real usage data.



## 2. Application Flow

Below is the general workflow of the system, including the public search capability and role-based access:

```mermaid
graph TD
    Public[Public Search Engine: No Login Required] --> |Find Asset| InfoCenter[Asset Info Center]
    
    Login[Login: Staff Required] --> Roles{Define Roles}
    
    Roles --> |Administrator| FullAccess[Full System Control & Settings]
    Roles --> |Operator| LifeCycle[Asset Life Cycle: Move, Fix, Auction]
    Roles --> |Supervisor| Reports[Business Intelligence & Reporting]

    FullAccess --> Setup[Setup Reference Data]
    Setup --> Master[Create Master Asset models]
    Master --> Series[Register Asset Series/SN]
    Series --> LifeCycle
    LifeCycle --> History[History Logging]
    History --> Reports
```

### Access Levels:
1.  **Public (Umum)**: Can access the **Asset Information Center** to search for assets by serial number without logging in.
2.  **Administrator**: Full access to all modules, including reference data, asset registry, transactions, reporting, and member management.
3.  **Operator**: Focused on the **Asset Life Cycle**. Can perform transactions like moving assets, logging repairs, and tracking historical updates.
4.  **Supervisor**: Focused on **Data Oversight**. Accesses detailed reports and audit trails for financial and operational analysis.



## 3. Installation with Docker

Follow these steps to run the application instantly using Docker.

### Prerequisites
*   Docker & Docker Compose installed.

### Included Files
The project already contains the necessary Docker files:
*   `Dockerfile`: Configures PHP 8.1 with Apache and `mysqli` extension.
*   `docker-compose.yml`: Sets up the application and MariaDB 10.1.19 database.

### Step 1: Choose Your Data Setup
Before running the system, choose how you want to initialize the database in `docker-compose.yml`:

*   **Option A: With Sample Data (Demo)**: To test the system with examples (Categories, Assets, Reports), ensure the following line is active in your `docker-compose.yml`:
    ```yaml
    - ./data-sample/struucture-with-data-sample.sql:/docker-entrypoint-initdb.d/init.sql
    ```
*   **Option B: Clean Structure (Production)**: For a fresh start without any data, uncomment the line below in `docker-compose.yml` instead:
    ```yaml
    - ./data-sample/structure-only.sql:/docker-entrypoint-initdb.d/init.sql
    ```

### Step 2: Running the Application
1.  Open your terminal in the project root.
2.  Run:
    ```bash
    docker-compose up -d
    ```
3.  Access the app at: `http://localhost:8080`

### Step 3: Database Verification
The application uses the credentials defined in [docker-compose.yml](file:///d:/mygithub-research/opensource-product/sbiz-asset/docker-compose.yml). 

**Automatic Config Status in `apps/config/config.php`**:
```php
$config['db']['server'] = 'db'; 
$config['db']['username'] = 'root';
$config['db']['password'] = 'root';
$config['db']['database'] = 'sbiz_asset';
```
*(No manual changes to PHP config are needed as I have already configured this for you).*



## 4. User Management

The application uses role-based member management to control access.

*   **Member List**: Shows all registered staff, their positions, and active status.
    ![Member Management](ss/39-user-management-hak-akses.jpg)
*   **Adding Users**: Create new staff accounts and set permissions.
    ![Add Member](ss/40-user-management-hak-akses-add.jpg)



## 5. User Manual

### Part 1: Dashboard and Search
The **Home Dashboard** provides a statistical summary of asset conditions and total investment value.
![Dashboard](ss/2-home.jpg)

The **Asset Info Center** allows quick searching of any asset by its serial number to see its current status, price, and location.
![Info Center](ss/1-pusat-informasi-asset.jpg)

### Part 2: Setting up Reference Data (Master Data)
Before adding assets, you must configure your organization's hierarchy:
*   **Funding Sources**: Record where assets were funded (e.g., Internal, Loans).
    ![Fund Source](ss/3-master-fund-source.jpg)
*   **Locations & Sub-Locations**: Manage buildings, rooms, and specific desks.
    ![Location](ss/4-master-location.jpg)
    ![Sub-Location Detail](ss/5-master-location-2.jpg)
*   **Departments**: List internal teams.
    ![Department](ss/6-master-department.jpg)
*   **Categories**: Group items like Electronics, Furniture, or Vehicles.
    ![Category](ss/7-master-category-asset.jpg)

### Part 3: Asset Registration
1.  **Main Asset Registry**: List various item models and sizes.
    ![Master Asset](ss/8-master-asset.jpg)
2.  **Asset Series (Units)**: Register each physical item with its unique Serial Number, Brand (Merk), and Purchase Date.
    ![Asset Series](ss/9-master-asset-series.jpg)
    ![Asset Series Update](ss/13-transaction-asset-series-update.jpg)

### Part 4: Managing Transactions
*   **Asset Movement**: Use the **Move** feature to officially transfer an item between locations.
    ![Asset Move](ss/14-transaction-asset-series-move.jpg)
    ![Asset Move Detail](ss/15-transaction-asset-series-move-detail.jpg)
*   **Repairs & Fixing**: Log maintenance activities and see when an item was last repaired.
    ![Asset Fix List](ss/16-transaction-asset-series-fixing.jpg)
    ![Asset Fix Detail](ss/17-transaction-asset-series-fixing-detail.jpg)
*   **Depreciation**: Automatically calculate the current book value for all assets at year-end.
    ![Depreciation Table](ss/10-transaction-depreciation.jpg)
    ![Create Auto Depreciation](ss/11-transation-depreciation-create-auto-depreciation.jpg)
    ![Run Depreciation Process](ss/12-transaction-depreciation-create-auto-depreciation.jpg)
*   **Auction & Disposal**: Manage the sale (lelang) of old assets.
    ![Auction](ss/18-transaction-asset-series-lelang.jpg)
*   **History Logs**: Every action (Move, Fix, Depreciate) is logged for full audit traceability.
    ![History List](ss/19-transaction-asset-series-history.jpg)
    ![History Detail View](ss/20-transaction-asset-series-history-detail.jpg)

### Part 5: Comprehensive Reporting and Auditing
Generate professional reports for management or tax purposes:

#### Financial & Values
*   **Asset Value Report**: Shows acquisition cost vs current (net) value.
    ![Value Report UI](ss/22-report-asset-value.jpg)
    ![Value Printout Preview](ss/23-report-asset-value-printout.jpg)
    ![Excel Value Export](ss/24-report-asset-value-excel.jpg)

#### Location & Audit
*   **Location-based Audit**: Know exactly what is in which room.
    ![Location Report](ss/25-report-asset-location.jpg)
    ![Location Asset Card](ss/26-report-asset-location-card-asset.jpg)
    ![Location Excel Export](ss/27-report-asset-location-card-asset-excel.jpg)
    ![Location Printout](ss/28-report-asset-location-printe.jpg)

#### Funding & Condition
*   **Funding Report**: Summary of assets based on source of funds.
    ![Asset by Fund Source](ss/29-report-aseet-by-fund-resource.jpg)
    ![Fund Source Printout](ss/30-report-aseet-by-fund-resource-print.jpg)
    ![Fund Source Excel Export](ss/31-report-aseet-by-fund-resource-excel.jpg)
*   **Physical Condition Report**: Summary of item health (Good vs Broken).
    ![Condition Report](ss/32-report-asset-conditionf-fisik.jpg)
    ![Condition Detail](ss/33-report-asset-conditionf-fisik-detail.jpg)
    ![Condition Printout](ss/34-report-asset-conditionf-fisik-detail-print.jpg)
    ![Condition Excel Export](ss/35-report-asset-conditionf-fisik-detail-exce;.jpg)

#### Movement & Sequence history
*   **Asset History Report**: Full trail of an asset's journey.
    ![History Report](ss/36-report-asset-history.jpg)
    ![History Printout](ss/37-report-asset-history-print.jpg)
    ![History Excel Export](ss/38-report-asset-history-excel.jpg)
*   **Last Serial Number**: Track the sequence of generated IDs.
    ![Last Serial Number Tracking](ss/21-report-asset-series-last-number.jpg)
