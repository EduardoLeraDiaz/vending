# Requirements
    - git
    - docker 
    - make

# Installation
```
git clone 
make install-dependencies
make create_db
```

# Use
To launch the command you need to enter the container with the following command
```
make enter
```
I recommend to use the service command with the products.json file as the first command.

# Commands

### Service
The command allow you to set the witch products are available, the price, and the stock.
He needs a JSON as parameter with the data. There is a file called "products.json" with example data to be used before start.
It returns a JSON with the data currently in the DB after calling it. 
The machine will start with no coins. So they need to be inserted for buy.  

example of use
```
bin/console vending:service "$(cat products.json)"
```

### Insert money
The command allow you to insert coins of 0.05, 0.10, 0.25, 1
The coins have to be inserted one by one. Like in a vending machine.

- bin/console vending:insert-money {value}

example of use
```
bin/console vending:insert-money 0.05
```

### Get balance
It returns the amount of money you currently have

example of use
```
bin/console vending:get-balance
```

### Return money
It returns the money you have inserted. It you will use the minimum amount of available coins.
So if you insert 10 coins of 10 cent and coins of 1 are available it will send you one 1 coin back.

example of use
```
bin/console vending:return-money
```

### Get product
The product to buy something. It will vend the product and return the rest of the money.
It can detect if it will be not enough coins for the return. In that case it sends an error asking you to use the exact amount. 

 - bin/console vending:get [product selector]

example of use
```
bin/console vending:get soda
``` 
