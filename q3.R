library(ggplot2)

data <- read.table(file="D:/RDATA/201701.csv", header=TRUE, sep=",")  #以read.table()將csv匯入並指定給data
data <- as.data.frame.matrix(data)                   #將data轉為data frame和matrix型態
days <- 0                                            #紀錄某時段的旅運量
date <- 0                                            #紀錄某日全時段的旅運量
per <- 0                                             #各站暫時變數用以加總
sum = matrix(1:35, nrow = 5, ncol = 7)               #紀錄每站每日總旅運量

for(k in c(1:5)){
  for(j in c(1:7)){                                  #抓取1/1-1/7的資料
    row <- array()                                   #紀錄開始抓取資料的列數
    row2 <- array()                                  #紀錄停止抓取資料的列數
    row[j] <- (21*(j-1))+1                           #計算從第幾列(幾點)開始抓取資料
    row2[j] <- 21*j                                  #計算到第幾列(幾點)停止抓取資料
    obj <- c(44, 44, 74, 39, 6)
    
    for (i in c(row[j]: row2[j])) { 
        if(class(data[i,obj[k]]) == "character"){    #19-31將csv檔中型態不為數字的值轉為數字
          t <- strsplit(data[i,obj[k]],",")          #將該筆資料以","為中間點做切割
          if(is.na(t[[1]][2])){                      #如逗號前沒有值則該數字為千位以下的數
            per <- as.integer(t[[1]][1])
          }else{                                     #如逗號前有值則該數字為千位以上的數
            per <- as.integer(t[[1]][1])*1000 + as.integer(t[[1]][2])
          }
        }else{
          per <- as.integer(data[i,j])
        }
        if(is.na(per)){
          next()
        }
      
        days [i] <- per                              #將暫存的資料丟進days陣列
        sum[k,j] <- sum[k,j] + days[i]               #將每個時段的資料做加總並丟進sum陣列
        date[j] <- data[row[j],1]                    #將資料的日期丟進date陣列
    }
  }
}

perDailySum <- data.frame(date, sum[1,], sum[2,], sum[3,], sum[4,], sum[5,])
ggplot(perDailySum, aes(x = date, group = 1)) +      #以date為x軸繪出折線圖
  geom_line(aes(y = sum[1,]), colour = "blue") +     #以台北車站日進站資料為y軸並以藍色線繪出
  geom_line(aes(y = sum[2,]), colour = "red") +      #以台北車站日進站資料為y軸並以紅色線繪出
  geom_line(aes(y = sum[3,]), colour = "green") +    #以西門日進站資料為y軸並以綠色線繪出
  geom_line(aes(y = sum[4,]), colour = "yellow") +   #以頂溪為日進站資料為y軸並以黃色線繪出
  geom_line(aes(y = sum[5,]), colour = "brown")      #以忠孝復興為日進站資料為y軸並以棕色線繪出

n <- c(sum[,1],sum[,2],sum[,3],sum[,4],sum[,5])

plot(n, pch = 17, col = "blue", cex =2)              #繪出資料散佈圖
points(mean(n), pch = 4, col = "red", cex = 2)      #畫平均數的點
points(median(n), pch = 3, col = "red", cex = 2)    #畫中位數的點

sd(n)                          #標準差 
var(n)                         #變異數
cv <- 100 * sd(n) / mean(n)    #變異係數 
cv 
range(n)[2] - range(n)[1]      #全距

summary(n)                     #總結數據
quantile(n)                    #百分位 