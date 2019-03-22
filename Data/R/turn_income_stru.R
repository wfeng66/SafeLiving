# This script is used for transforming data structure to fit my database design
# Original: County	1988	1989	1990	1991
# Result:	County	Year	Income

// convert income data
df <- read.csv("H://CSI/ISI 490/Datasets/Income/income_tran.csv", head = TRUE, stringsAsFactors = FALSE)
// create dt data frame for storing new table
dt <- data.frame(matrix(ncol = 3, nrow = 0))
x <- c("County", "Year", "Income")
colnames(dt) <- x
// convert
for(r in 1:60)
{
	for (c in 2:30)
	{
		dt[(r-1)*29+c,1]<-df[r,1]
		dt[(r-1)*29+c,2]<-colnames(df[c])
		dt[(r-1)*29+c,3]<-df[r,c]
	}
}

// get rid of the " County" string in the first field
for (k in  1:nrow(dt))
{
	dt[k,2] <- sub(pattern="X",replacement = "", x = dt[k,2])
}

write.csv(dt, "H://CSI/ISI 490/Datasets/Income/income_v1.csv")



// convert house price data
df <- read.csv("H://CSI/ISI 490/Datasets/House/houseprice.csv", head = TRUE, stringsAsFactors = FALSE)
// create dt data frame for storing new table
dt <- data.frame(matrix(ncol = 3, nrow = 0))
x <- c("County", "Year", "Price")
colnames(dt) <- x
// convert
for(r in 1:60)
{
	for (c in 2:24)
	{
		dt[(r-1)*24+c,1]<-df[r,1]
		dt[(r-1)*24+c,2]<-colnames(df[c])
		dt[(r-1)*24+c,3]<-df[r,c]
	}
}

// get rid of the " County" string in the first field
for (k in  1:nrow(dt))
{
	dt[k,1] <- sub(pattern=" County",replacement = "", x = dt[k,1])
	dt[k,2] <- sub(pattern="X",replacement = "", x = dt[k,2])
}

write.csv(dt, "H://CSI/ISI 490/Datasets/House/houseprice_v1.csv")
