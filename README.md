modera
======
PART1 
- parsed list of items to tree 

PART3 
- ExtJS 4 Tree example with data from part 1 converted into REST service and returnd by getAll request in JSON format 

PART 2
- includes in itself PART 1 and PART 3
  - part 1 representation on default controller app_dev.php
  - part 3 representation app_dev.php/tree
  - part 2 are fully used and included in part 3(Treeview) or can be available under app_dev.php/item
    - service use additional parameter _format with values json (default) and xml
    - service is using data from part 1 parsed and prepared for the work
    - service has next actions
      - allAction() that returns all the items list. Available under app_dev.php/item/{id} (request method GET)
      - getAction(id) that returns single item by its id. Available under app_dev.php/item/{id} (request method GET)
      - newAction() that saves new item. Available under app_dev.php/item (request method POST)
      - editAction($id) that updates old item. Available under app_dev.php/item/{id} (request method PUT)
      - removeAction($id) that removes existed item. Available under app_dev.php/item/{id} (request method DELETE)
       
  PS: important! service itself cant save/drop/update/add (CRUD) data into csv fail, it only represents(simulate) the possibility to do it.
      

