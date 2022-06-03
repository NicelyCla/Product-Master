# Product-Master
Simple database management using php and HTML.
Not very useful, hastily written, just a project for learning databases.

## Application
The project tends to simulate an online sales portal.
Despite the single login, there are three different categories of users:
- The administrator (root).
- The common user.
- The supplier.

Depending on the type of membership, the site will redirect to the areas differently.
To visit all the pages correctly, you must log in with at least one user for each category.

### The root user:
- Can view sales and purchase invoices depending on the category and time frame indicated.
- Can view, edit and delete users and suppliers.
- Can view, add, edit and delete products.

### Common users:
- They can view the available products, add them to their cart, and then proceed with the purchase.
- They can modify their own basic information.
- Common users are not allowed access to the area reserved for suppliers, nor access to the administration area

### Suppliers can:
- Upload your own sales invoices.
- Replenish the stocks in the warehouse of the indicated product.
- Suppliers are not allowed access to the area reserved for common users, nor access to the administrator area.
