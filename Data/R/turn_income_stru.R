# This script is used for transforming data structure to fit my database design
# Original: County	1988	1989	1990	1991
# Result:	County	Year	Income

dt <- data.frame(matrix(ncol = 3, nrow = 0))
x <- c("County", "Year", "Income")
colnames(dt) <- x

for(r in 1:len(df))
{
	for (c in 1:30)
	{
		dt[(r-1)*29+c,1]=df[r,1]
		dt[(r-1)*29+c,2]=df[0,c]
		dt[(r-1)*29+c,3]=df[r,c]
	}
}