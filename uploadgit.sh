git init
echo "-"
git status

echo "-"
git add .

echo "-"
foo="Commitedat "
Datedta="$(date +%d%m%Y%H%M%S)"
dd="$(echo $foo${Datedta})"

echo "-"
git commit -m ${dd}

echo "-"
git status

echo "-"
git push -u origin master

