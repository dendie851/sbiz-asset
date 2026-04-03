# Simple Small Business Asset (Sbiz-Asset)

A lightweight asset management system designed for small and medium-sized businesses to manage inventory, track asset lifecycles, and handle financial depreciation.

## 1. Business Purpose and Benefits

**Sbiz-Asset** helps businesses stay organized by providing a central place to record all fixed assets (furniture, electronics, machinery, etc.). 

*   **Financial Clarity**: Track asset values, acquisition costs, and current net values after depreciation.
*   **Asset Auditing**: Easily track where each asset is located and which department is responsible for it.
*   **Operational Efficiency**: Manage repairs and maintenance history to prevent equipment failure.
*   **Strategic Planning**: Detailed reports help in planning future equipment purchases and budgeting.

---

## 2. Application Flow

Below is the general workflow of the system from setup to reporting:

```mermaid
graph TD
    A[Start: Setup Reference Data] --> B[Create Master Asset models]
    B --> C[Register Asset Series / Serial Numbers]
    C --> D{Asset Lifecycle}
    D --> |Move| E[Location Transfer]
    D --> |Repair| F[Maintenance Log]
    D --> |Year End| G[Auto Depreciation]
    D --> |End of Life| H[Leasing/Auction]
    E --> I[History Tracking]
    F --> I
    G --> I
    H --> I
    I --> J[Financial & Audit Reports]
```

1.  **System Config**: Initialize locations, funds, and categories.
2.  **Asset Entry**: Register models and then individual units (Serial Numbers).
3.  **Transactions**: Track and update asset status periodically.
4.  **Reporting**: Export audit and financial data.

---

## 3. Installation with Docker

Follow these steps to run the application instantly using Docker.

### Prerequisites
*   Docker & Docker Compose installed.

### Included Files
The project already contains the necessary Docker files:
*   `Dockerfile`: Configures PHP 8.1 with Apache and `mysqli` extension.
*   `docker-compose.yml`: Sets up the application and MariaDB 10.1.19 database.

### Running the Application
1.  Open your terminal in the project root.
2.  Run:
    ```bash
    docker-compose up -d
    ```
3.  Access the app at: `http://localhost:8080`

### Database Setup
The database is automatically pre-configured using `data-sample/struucture-with-data-sample.sql`. 

**Current Database Config in `apps/config/config.php`**:
```php
$config['db']['server'] = 'db'; 
$config['db']['username'] = 'root';
$config['db']['password'] = 'root';
$config['db']['database'] = 'sbiz_asset';
```

---

## 4. User Management

The application uses role-based member management to control access.

*   **Member List**: Shows all registered staff, their positions, and active status.
    ![Member Management](ss/39-user-management-hak-akses.jpg)
*   **Adding Users**: Create new staff accounts and set permissions.
    ![Add Member](ss/40-user-management-hak-akses-add.jpg)

---

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
