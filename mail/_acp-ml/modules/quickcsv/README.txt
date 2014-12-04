README.txt
.---------------------------------------------------------------------------.
|  Software: QuickCSV Suite (CSV To MySQL and MySQL To CSV                  |
|   Version: 1.0                                                            |
|      Info: http://www.worxware.com                                        |
| ------------------------------------------------------------------------- |
|     Owner: Worx International Inc., Andy Prevost                          |
|    Author: Andy Prevost (andy.prevost@worxteam.com)                       |
| Copyright (c) 2008-2009, Andy Prevost. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Attribution-Noncommercial-No Derivative Works 3.0 Unported     |
|                                                                           |
|            You are allowed:                                               |
|            - to Share: to copy, distribute and transmit the work          |
|                                                                           |
|            Under the following conditions:                                |
|            Attribution - You must attribute the work in the manner        |
|              specified by the author or licensor (but not in any way that |
|              suggests that they endorse you or your use of the work).     |
|            Noncommercial - You may not use this work for commercial       |
|              purposes.                                                    | 
|            No Derivative Works - You may not alter, transform, or build   |
|              upon this work.                                              |
|                                                                           |
|            With the understanding that:                                   |
|            Waiver - Any of the above conditions can be waived if you get  |
|              permission from the copyright holder.                        |
|            Other Rights - In no way are any of the following rights       |
|              affected by the license:                                     |
|              * Your fair dealing or fair use rights;                      |
|              * The author's moral rights;                                 |
|              * Rights other persons may have either in the work itself or |
|                in how the work is used, such as publicity or privacy      |
|                rights.                                                    |
|                                                                           |
|            For more information on this license type:                     |
|            http://creativecommons.org/licenses/by-nc-nd/3.0/              |
|                                                                           |
|            IF YOU WISH TO USE 'QuickCSV Suite'  IN A COMMERCIAL OR        |
|            REVENUE-GENERATING PROJECT OR WEBSITE, PLEASE CONTACT US FOR A |
|            COMMERCIAL LICENSE.                                            |
|                                                                           |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.worxware.com):                    |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'

NOTE: This is version 1.0.

Projects with CSV uploads were not high-priority - I usually only ended up
having to upload a CSV file about once each month. As the volumes increased,
I searched years for a utility to handle the uploads. There simply isn't anything 
available that would cut down the amount of time coding or fiddling with the
CSV to get it to conform to the scripts I tested.

One of the problems with coding for each CSV is the incredible amount of time wasted
maping each CSV field with the database table fields.

Despite having a staff of Zend Certified PHP programmers, we never found the
time or proper individual to write a utility to automate the process.

In early 2008, the volume of CSV files that we needed to upload to MySQL
increased substantially. We started to write an automation utility to handle
the uploads. We have refined it considerably and the code no longer needs 
much maintenance. The features of CSV2MySQL are incredible:

- included sample .htaccess can increase your maximum file upload size in
  real time
- one single database configuration file to connect to your MySQL database
- reads and displays all available tables in your database (and number of
  records in each) and lets you select which table to upload to
- use the built-in file upload or FTP your CSV files directly to the server
  (to the files/ folder)
- select field separator (comma, or tab)
- select field enclosure (double quote, single quote, or none)
- select option of using first record as header fields in the CSV
- select option to allow/deny duplicate records
- select option to purge existing records in your table (great for conversion)
- select option to delete CSV file after uploading processing
- excellent CSV field to Table field mapping ... very visual
  - include or exclude any field and map from/to any field
- option to save field mapping for reuse

... and best of all it is incredibly fast. Since we've been working with this
utility for more than one year now, you also are assured that it works and is
stable.

Another missing "must-have" was a script to transfer MySQL table fields to a
CSV file ... again, there are utilities out there, but most are as close to
useless as possible. The only two functional methods that really work the way
they are supposed to is the phpMyAdmin MySQL database manager's CSV export 
functionality (but that isn't very flexible, you can't choose which fields you
want) - or writing a script for each MySQL to CSV process you need.

Since we needed to use MySQL essentially to sanitize and clean data, it meant
that getting the data out of MySQL became a regular task. We chose to write our
own ... and the result simply awes me each time I use it. The features of 
MySQL2CSV are:

- one single database configuration file to connect to your MySQL database
- reads and displays all available tables (and number of records in each) in
  your database and lets you select which table to download from
- excellent Table field selector ... very visual
  - include or exclude any field
  - select any single field as DISTINCT (eliminates duplicates on a key field)
  - choose whether to exclude a record if a particular field is empty (like
    email address)
  - choose to do case conversion on the field (like strtoupper() or
    (strtolower())
  - choose to do field conversion (like ucwords() or any other single PHP
    function)
- select field separator (comma, or tab)
- select field enclosure (double quote, single quote, or none)
- CSV created includes header fields as the first record in the CSV
- select file name to export as
- include a Query to pre-process (before the selection of the records for
  output to CSV file)
- include a Query to process the selection of the records for output to CSV
  file (can be useful if the records returned aren't quite what you expected)
- select option to purge existing records in your table after exporting to CSV

Even though this is designed to work with your existing database tables, we
have included 'vcard.sql' that we use regular for contact type information
processing.

We have also included a sample .htaccess file in the root directory of the
QuickCSV Suite. It's primary purpose is to demonstrate how to use .htaccess
to increase the maximum file size for uploads to 20 Mb. Please note the other
.htaccess files within directories of QuickCSV Suite are to protect your
uploaded data.

Overall, this is a very flexible package that fill our needs entirely. We've
found it to be far more powerful than commercial packages and far surpasses
any Open Source or commercial script that is currently available.

Our CSV utilities are proprietary licensed. You are given permission to use
the QuickCSV Suite as long as you do not remove any of the copyright notices 
in any of the files, and do not remove the copyright notices that display with
the application functionality on screen. The QuickCSV Suite can be used only
for not-for-profit uses and not-for-profit websites. For commercial or for-profit
uses and websites, please contact us for an appropriate license.

If you use our QuickCSV Suite, we'd like to hear from you.

For installation instructions, please read the DOCS/INSTALL.txt document.

Enjoy!
Andy Prevost
www.worxware.com
