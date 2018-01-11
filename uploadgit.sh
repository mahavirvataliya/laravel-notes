git init
git status
git add .
current_date_time = "Comminted at "
current_date_time+="`date +%Y%m%d%H%M%S`"
git commit -m $current_date_time
git status
git push -u origin master

