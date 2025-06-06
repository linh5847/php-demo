Azure Web App https://medium.com/@morsi.masmoudi/build-your-first-azure-web-app-to-host-a-php-web-application-14346013d57c 

WAF = https://medium.com/@morsi.masmoudi/secure-your-web-application-with-an-azure-waf-web-application-firewall-d4e0c810bab0 

1. Logon to portal.azure.com and search for web app. Click on web app
2. Provides a resource-group name i.e phpwebapprg and web-app-name i.e phpwebapp. Select location ie UK South and runtime ie php8.2.
3. Pay attention to price plan. Select free for demo purposes only. Create Review+Create
4. Wait until it is complete. Click Go to resource button that is appeared on the screen.
5. If you go to resource-group name which we created called phpwebapprg. We notice that the web-app phpwebapp with another name called ASP-phpwebapp-9162 this Linux VM
6. Check to see it is accessible. Go to resource phpwebapp and click browser. This will pop up into an internet browser and after few second an initial web page load up.
7. Click Setting->Scale up (App Service plan). Click Select and Upgrade.
8. Create a GitHub repository ie php-demo and create a new file call index.php with   <?php echo("Hello World"); ?>
9. Go back to azure portal and click on web-app name phpwebapp. Click Deployment->Deployment Center->Setting Source. Select GitHub and click Authorised.
10. Wait for couple minutes for network to synchronised the connection between azure portal and GitHub. Click refresh and select Setting Source again. Select GitHub and this time hopefully you will see the signed-in, organisation, repository and branch. Select the appropriate and click save at the top.
11. Click logs at the top and wait until the deployment is complete and message say succeeded.
12. If we click browser again or refresh the page from the last time we click. You will see the Hello World message appear this time.
13. Grant a developer, tester, etc permission. Go to phpwebapp name and click Access Identity on the left panel. Click Add and select Website Contributors. Click next and select group or members and add each one. Click Review + Assign.
14. Create MySQL Database. Search mysql and select Azure Database for MySQL Flexible Server as a demo purpose. Click create->Flexible Server. 


DBName = phpdb
Version = 8.0
Region = UK South
Workload Type = Development
Authentication method = MySQL Authentication only	# Optional MySQL and Microsoft Entra authentication for real project
Username: dbadmin
Pass:M!******0r*******4

Click Next->Public Access Allow->Firewall Rules. Add IP address ie 0.0.0.0. Click Review + Create. Wait until it is complete

Before Download SSL Certificate. Click Server Parameter->Require_secure_transport=ON. Can be turned off for testing only. Download SSL certificate.

Grant User to MySQL database. Click MySQL Database name ie phpdb->Access Control->Choose Contributor or Database Contributor. Select members or group

PHP code

<?php
$servername = "phpdb.mysql.database.azure.com";
$username = "dbadmin";
$password = "M1ke0rBreak1234";
$database = "demo";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to the database successfully!";

// Perform database operations here...

// Run the create table query
if (mysqli_query($conn, '
CREATE TABLE Products (
`Id` INT NOT NULL AUTO_INCREMENT ,
`ProductName` VARCHAR(200) NOT NULL ,
`Color` VARCHAR(50) NOT NULL ,
`Price` DOUBLE NOT NULL ,
PRIMARY KEY (`Id`)
);
')) {
printf("Table created\n");
}

//Create an Insert prepared statement and run it
$product_name = 'BrandNewProduct';
$product_color = 'Blue';
$product_price = 15.5;
if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Color, Price) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $product_name, $product_color, $product_price);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

// Close the connection
$conn->close();
?>

If this deploy successfully. Go to web app CLI using bash and make a connection to the database. Check by show tables; select * from products;

WAF

Azure Front Door allows request distribution across multiple regions, ensuring high availability and global scale
Application Gateway operates at a regional level

Create a new Azure resource-group ie RG-waf 
Search for front door and CDN profile->Custom Create->Continue to create front door->Select RG-waf for resource-group->Gives a name ie Fdwaf->Premium
Click Endpoint on top->Add endpoint->Gives a name ie spzwaf->Add
Click AddRoute inside the endpoint->Gives a name ie webapp1 which we have just created a moment ago->Add new domain.

DNS Management->All other DNS services
Custom Domain = This is a custom DNS name that you will register on the DNS ie webapp1-waf.azurewebsites.net

NOTE: Only do this if you have a valid register DNS name. Alternate, leave it out if you create a demo one.

Origin Group. Click Add a new origin group->Gives a name ie webapp1origin->click Add add origin underneath the origin group name which you have just entered.


Name = webapp1
Origin Type = Custom
Host name = The web app we were created previously and browsing it. Enter that url without https:// ie phpwebapp-b0dtfwghayb9bxa7.uksouth-01.azurewebsites.net
Origin host header = will be inherit from host name. So should be the same
Leave all others as default.

Click Add

Click Add again, as this now now belonging to Add an Origin Group

Click Add. This is now our first AddRoute is appearing. Check it out 

Click Review + Create

Wait until it is deploying successfully.

We need to validate the domain. If you click on the Front door name ie Fdwaf and select Domains under setting. You notice it is pending.

Click Pending->Regenerate

Remember the Front Door DNS name must be fully registered and validate with the Domain Register for validate and approval. Once it is approved. It can be tested.
