# In-Depth Project Overview: Sanskrit Shloka Application

## 1. Project Purpose

The Sanskrit Shloka Application is a **collaborative web-based tool for building, managing, and curating a rich database of Sanskrit verses (shlokas) and their associated knowledge.** It is a specialized Content Management System (CMS) designed for a team of users with different responsibilities, all working together to create a high-quality, structured dataset.

## 2. User Roles & Workflow

The application is built around a clear, multi-step workflow involving four distinct user roles:

1.  **Fixed Data Entry Operator (`fixed_entry`):**
    *   **Responsibility:** To enter the core, "fixed" information about a shloka.
    *   **Actions:** They can create a new shloka entry, providing its Sanskrit text, translations (Hindi & English), and source information (text name, chapter, verse, etc.).

2.  **Variable Data Entry Operator (`variable_entry`):**
    *   **Responsibility:** To enrich existing shlokas with "variable" or supplementary data.
    *   **Actions:** They can browse the list of shlokas and add Question & Answer pairs, keywords, and context to them.

3.  **Approver (`approver`):**
    *   **Responsibility:** To act as a content moderator and quality control specialist.
    *   **Actions:** They review all the data submitted by both Fixed and Variable Entry operators. They can choose to **approve** the content, making it publicly visible, or **reject** it.

4.  **Administrator (`admin`):**
    *   **Responsibility:** To oversee the entire application.
    *   **Actions:** An admin has full power. They can perform all the actions of the other roles (create, edit, approve) and also manage users and perform system-wide actions like exporting data.

### The Workflow in Action:

*   A `Fixed Entry` user creates a new shloka. This shloka is saved to the database but is marked as **"Pending Approval"**.
*   Other users, including `Variable Entry` users, can now see this pending shloka. They can view its details and add Q&A pairs to it. These Q&A pairs are also saved as "Pending Approval".
*   An `Approver` or `Admin` logs in and sees a queue of pending items on their dashboard. They review the content for accuracy and can approve it, which makes it part of the official, visible dataset.

---

## 3. Core Features of the Application

1.  **Role-Specific Dashboards:** Each user role has a unique dashboard tailored to their tasks. For example, an approver's dashboard highlights pending submissions, while a data entry operator's dashboard provides quick links to create new entries.

2.  **Shloka Navigation Sidebar:** For easy access, a persistent sidebar on the left of the screen lists every shloka in the system. This allows any logged-in user to quickly jump to any shloka's detail page without having to search through a list.

3.  **Comprehensive Shloka Detail Page:** This is the heart of the application's data visibility. This page:
    *   Displays all fixed data for a single shloka.
    *   Crucially, it **lists all Q&A pairs** that have ever been submitted for that shloka. This is the key feature that prevents data redundancy, as users can see what has already been entered before adding new information.
    *   Provides authorized users with links to "Add a new Q&A" or "Edit Shloka".

4.  **Granular JSON Export:** A powerful tool that allows any authorized user to export data from the application.
    *   It features a form with **checkboxes for every single data field** (e.g., `sanskrit_shloka`, `translations`, `question`, `answer`, etc.).
    *   A user can select any combination of fields they want, and the system will generate a custom-structured JSON file for them to download.

5.  **Robust Authorization System:** The application uses Laravel's Gate and Policy system to control permissions. This ensures that actions like editing, deleting, approving, or exporting data can only be performed by users with the correct roles.

## 4. How it All Works Together

This application is designed to be a "data entry tool" where a team can collaborate effectively. The workflow separates duties, the approval system ensures quality, and the UI is built to make data entry as efficient as possible. The sidebar allows for rapid navigation, and the detail page ensures that everyone has full visibility into the existing data, preventing duplicate work. Finally, the export feature provides a flexible way to get the high-quality, curated data out of the system for other uses.
