# Simple Small Business Asset (Sbiz-Asset)

## Table of Contents
*   [Introduction](#introduction)
*   [📄 License](#-license)
*   [1. Business Purpose and Benefits](#1-business-purpose-and-benefits)
*   [2. Application Flow](#2-application-flow)
*   [3. Installation with Docker](#3-installation-with-docker)
*   [4. User Management](#4-user-management)
    *   [Member List UI](#member-list-ui)
    *   [Adding New Members](#adding-new-members)
*   [5. User Manual](#5-user-manual)
    *   [Part 1: Dashboard and Search](#part-1-dashboard-and-search)
        *   [Public Asset Information Center](#public-asset-information-center)
        *   [Internal Home Dashboard](#internal-home-dashboard)
    *   [Part 2: Setting up Reference Data](#part-2-setting-up-reference-data)
        *   [Fund Source Master](#fund-source-master)
        *   [Location & Sub-Location Master](#location--sub-location-master)
        *   [Department & Asset Categories](#department--asset-categories)
    *   [Part 3: Asset Registration](#part-3-asset-registration)
        *   [Main Asset Models Registry](#main-asset-models-registry)
        *   [Asset Series/Unit Registration](#asset-seriesunit-registration)
        *   [Updating Asset Details](#updating-asset-details)
    *   [Part 4: Managing Life Cycle Transactions](#part-4-managing-life-cycle-transactions)
        *   [Year-End Auto Depreciation](#year-end-auto-depreciation)
        *   [Asset Movement & Location Transfer](#asset-movement--location-transfer)
        *   [Equipment Maintenance & Repair](#equipment-maintenance--repair)
        *   [Asset Auction (Disposal)](#asset-auction-disposal)
        *   [Global & Unit History Audit Trails](#global--unit-history-audit-trails)
    *   [Part 5: Comprehensive Reporting and Exports](#part-5-comprehensive-reporting-and-exports)
        *   [Section A: Financial Valuation Reports (PDF/Excel)](#section-a-financial-valuation-reports-pdfexcel)
        *   [Section B: Location Distribution Reports (PDF/Excel)](#section-b-location-distribution-reports-pdfexcel)
        *   [Section C: Funding Resource Reports (PDF/Excel)](#section-c-funding-resource-reports-pdfexcel)
        *   [Section D: Physical Condition Audits (PDF/Excel)](#section-d-physical-condition-audits-pdfexcel)
        *   [Section E: Master Activity & Audit Log Reports (PDF/Excel)](#section-e-master-activity--audit-log-reports-pdfexcel)

## Introduction

Managing physical assets is a critical challenge for growing businesses. Without a proper system, tracking furniture, electronics, and specialized equipment often leads to data loss, missing items, and inaccurate financial records. 

**Simple Small Business Asset (Sbiz-Asset)** is an **Open Source** initiative and a comprehensive management solution. It is designed to help organizations move away from manual spreadsheets and towards a professional process that prevents asset loss and eliminates wasteful duplicate spending. Open for anyone to use, modify, and develop, the system is available for free under the MIT License to support better asset governance worldwide.

## 📄 License

This project is licensed under the **MIT License**. You are free to use, modify, and distribute this software for personal or commercial purposes. See the [LICENSE](file:///d:/mygithub-research/opensource-product/sbiz-asset/LICENSE) file for more details.

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

### Member List UI
*   **[Screen 39] Member List**: Displays all staff members, their roles (Supervisor/Operator/Admin), and their current active status.
    ![Member List](ss/39-user-management-hak-akses.jpg)

### Adding New Members
*   **[Screen 40] Add New Member**: A dedicated form to create new user accounts and assign their specific job position for system security.
    ![Add Member](ss/40-user-management-hak-akses-add.jpg)

## 5. User Manual

This manual provides a detailed walkthrough of every screen feature available in the system.

### Part 1: Dashboard and Search
The core interfaces for everyday lookup and status tracking.

#### Public Asset Information Center
*   **[Screen 1] Asset Information Center**: A public-facing search page where users search by Asset Serial Number to see detailed price, location, and condition.
    ![Asset Information Center](ss/1-pusat-informasi-asset.jpg)

#### Internal Home Dashboard
*   **[Screen 2] Home Dashboard**: The internal home screen showing statistics for total asset value, asset health (Good, Fair, Broken), and the most recent 30 activities.
    ![Dashboard](ss/2-home.jpg)

### Part 2: Setting up Reference Data
These foundational data entries are required before assets can be registered.

#### Fund Source Master
*   **[Screen 3] Fund Source Master**: Manage the list of funding origins (e.g., Internal Capital, Bank Loans, Grants).
    ![Fund Source](ss/3-master-fund-source.jpg)

#### Location & Sub-Location Master
*   **[Screen 4] Main Location Master**: Manage top-level organization buildings and sites.
    ![Location](ss/4-master-location.jpg)
*   **[Screen 5] Sub-Location Detail**: Allows users to drill down from a main location to specific rooms or office corners.
    ![Sub-Location](ss/5-master-location-2.jpg)

#### Department & Asset Categories
*   **[Screen 6] Department Master**: Manage organization structure such as IT, HR, and Operations.
    ![Department](ss/6-master-department.jpg)
*   **[Screen 7] Asset Categories**: Group your assets into classes like "Electronics", "Furniture", or "Buildings" for better reporting.
    ![Category](ss/7-master-category-asset.jpg)

### Part 3: Asset Registration
The workflow for adding physical objects into the system.

#### Main Asset Models Registry
*   **[Screen 8] Main Asset Registry**: Register general models (e.g. register "Samsung 65-inch TV").
    ![Master Asset](ss/8-master-asset.jpg)

#### Asset Series/Unit Registration
*   **[Screen 9] Asset Series Registration**: List specific physical units. Each entry has its own unique Serial Number and acquisition price.
    ![Asset Series Registration](ss/9-master-asset-series.jpg)

#### Updating Asset Details
*   **[Screen 13] Asset Series Update**: A form to modify the basic details and financial valuation of an existing asset series unit.
    ![Asset Series Update](ss/13-transaction-asset-series-update.jpg)

### Part 4: Managing Life Cycle Transactions
Tracking and recording what happens to an asset as it ages.

#### Year-End Auto Depreciation
*   **[Screen 10] Depreciation List Table**: View all historical depreciation records by year.
    ![Depreciation List](ss/10-transaction-depreciation.jpg)
*   **[Screen 11] Prepare Auto-Depreciation**: Set the target year for the asset depreciation process.
    ![Prepare Auto-Depreciation](ss/11-transation-depreciation-create-auto-depreciation.jpg)
*   **[Screen 12] Execute Auto-Depreciation**: Final confirmation after the batch depreciation process finishes.
    ![Execute Auto-Depreciation](ss/12-transaction-depreciation-create-auto-depreciation.jpg)

#### Asset Movement & Location Transfer
*   **[Screen 14] Asset Movement Form**: The official form for moving an asset to a new location.
    ![Asset Movement Form](ss/14-transaction-asset-series-move.jpg)
*   **[Screen 15] Movement History Review**: Displays the movement history for a specific unit.
    ![Asset Move History](ss/15-transaction-asset-series-move-detail.jpg)

#### Equipment Maintenance & Repair
*   **[Screen 16] Asset Fixing/Repair List**: A dashboard tracking all repair requests.
    ![Repair List](ss/16-transaction-asset-series-fixing.jpg)
*   **[Screen 17] Repair Completion Detail**: Confirm that a repair is finished and update condition to "Good".
    ![Repair Detail](ss/17-transaction-asset-series-fixing-detail.jpg)

#### Asset Auction (Disposal)
*   **[Screen 18] Asset Auction (Lelang)**: For assets being retired or sold, this screen logs the sale process.
    ![Auction](ss/18-transaction-asset-series-lelang.jpg)

#### Global & Unit History Audit Trails
*   **[Screen 19] Asset General History**: A global log showing every single transaction across the organization.
    ![General History](ss/19-transaction-asset-series-history.jpg)
*   **[Screen 20] Specific Asset Audit Detail**: A deep-dive history for a single asset unit.
    ![Specific Asset Audit](ss/20-transaction-asset-series-history-detail.jpg)

### Part 5: Comprehensive Reporting and Exports
Data output options for supervisors to audit the physical and financial state of assets.

#### Section A: Financial Valuation Reports (PDF/Excel)
*   **[Screen 22] Financial Asset Value UI**: An interactive report showing current values across departments.
    ![Asset Value](ss/22-report-asset-value.jpg)
*   **[Screen 23] Asset Value Printout**: A cleaned print-ready PDF preview.
    ![Value Printout](ss/23-report-asset-value-printout.jpg)
*   **[Screen 24] Asset Value Excel Preview**: Spreadsheet-style preview of the financial data.
    ![Asset Value Excel](ss/24-report-asset-value-excel.jpg)

#### Section B: Location Distribution Reports (PDF/Excel)
*   **[Screen 25] Master Asset Location Report**: Distribution of all assets across organization sites.
    ![Asset Location Report](ss/25-report-asset-location.jpg)
*   **[Screen 26] Asset Location Card**: Visual assignment cards for assets in permanent rooms.
    ![Location Card](ss/26-report-asset-location-card-asset.jpg)
*   **[Screen 27] Asset Location Card (Excel)**: Excel export version of the location list.
    ![Location Report Excel](ss/27-report-asset-location-card-asset-excel.jpg)
*   **[Screen 28] Asset Location Printout**: A PDF report specifically categorized by building location.
    ![Location Printout](ss/28-report-asset-location-printe.jpg)
*   **[Screen 21] Last Item Serial Number Tracker**: Identifies the last sequence of generated serial numbers.
    ![Last Serial Number Tracker](ss/21-report-asset-series-last-number.jpg)

#### Section C: Funding Resource Reports (PDF/Excel)
*   **[Screen 29] Assets by Fund Source Report**: Summary of investment counts based on funding origin.
    ![Fund Resource Report](ss/29-report-aseet-by-fund-resource.jpg)
*   **[Screen 30] Fund Source Report Printout**: Formal dokument for donors or banks.
    ![Fund Source Printout](ss/30-report-aseet-by-fund-resource-print.jpg)
*   **[Screen 31] Fund Source Report (Excel)**: Raw data for financial analysts.
    ![Fund Source Excel](ss/31-report-aseet-by-fund-resource-excel.jpg)

#### Section D: Physical Condition Audits (PDF/Excel)
*   **[Screen 32] Asset Condition Summary**: Management overview of physical health.
    ![Condition Summary](ss/32-report-asset-conditionf-fisik.jpg)
*   **[Screen 33] Asset Condition Detail Breakdown**: A granular listing for all unit health status.
    ![Condition Detail](ss/33-report-asset-conditionf-fisik-detail.jpg)
*   **[Screen 34] Asset Condition Print Preview**: A document used for field audits to verify units.
    ![Condition Printout](ss/34-report-asset-conditionf-fisik-detail-print.jpg)
*   **[Screen 35] Asset Condition (Excel)**: Condition data used for bulk analysis.
    ![Condition Excel](ss/35-report-asset-conditionf-fisik-detail-exce;.jpg)

#### Section E: Master Activity & Audit Log Reports (PDF/Excel)
*   **[Screen 36] Global Performance & History Report**: A master report of all system performance.
    ![History Report](ss/36-report-asset-history.jpg)
*   **[Screen 37] Global History Print Preview**: The hard-copy version of the system-wide activity log.
    ![History Report Print](ss/37-report-asset-history-print.jpg)
*   **[Screen 38] Global History (Excel)**: An exhaustive list of every log available for download.
    ![History Report Excel](ss/38-report-asset-history-excel.jpg)
