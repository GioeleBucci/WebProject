# KIWI - A Web Project

<p align="center">
  <img src="website/assets/logo.png" alt="KIWI logo" width="100" />
</p>

A small e-commerce website inspired by IKEA, built with standard web technologies (PHP, HTML, CSS, JavaScript) for the "Web Technologies" course (AY 2024/2025).

<p align="center">
  <img src="mockup/mockup.png" alt="mockup" width="50%" />
</p>

## Features
- Authentication (login/register) and account management  
- Role-based access (buyer/seller)
- Product browsing and search with filters
- Notifications
- Responsive design (mobile-friendly)

**Buyer users features:**
- Wishlist
- Cart and checkout flow
- Orders history

**Seller users features:**
- Manage articles (view/add products)
- Edit articles
- Possibility to add multiple versions of the same article

## Setup (local)
In order to create and populate the database used by the website the two following queries must be run beforehand:
   1. [db/dbCreate.sql](../db/dbCreate.sql)
   2. [db/dbPopulate.sql](../db/dbPopulate.sql)

Then the app can be served by a local web server so that it is accessible at: `http://localhost/WebProject/website/src/`
