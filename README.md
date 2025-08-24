# db-index
in this project, I'm training to apply db indexes.  
I want to create several tables with different indexes and compare read/write speed.  

https://habr.com/ru/companies/otus/articles/747882/

# how to run
docker compose up
analysis will be available on localhost:81

# how to add table to comparison
- copy one of existing migrations  
- add your index  
- create an entity class for it with a repository, make sure to use base classes to get rid of boilerplate  
- all available methods will be run automatically
- visit localhost:81 to see the results