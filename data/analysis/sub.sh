#!/bin/bash

sed -i "s/12-14 years/12\, 14/g" AdultBMI.csv
sed -i "s/12-19 years/12\, 19/g" AdultBMI.csv
sed -i "s/15-19 years/15\, 19/g" AdultBMI.csv
sed -i "s/20-24 years/20\, 24/g" AdultBMI.csv
sed -i "s/20-34 years/20\, 34/g" AdultBMI.csv
sed -i "s/25-34 years/25\, 34/g" AdultBMI.csv
sed -i "s/35-44 years/35\, 44/g" AdultBMI.csv
sed -i "s/45-54 years/45\, 54/g" AdultBMI.csv
sed -i "s/45-64 years/45\, 64/g" AdultBMI.csv
sed -i "s/55-64 years/55\, 64/g" AdultBMI.csv
sed -i "s/65-74 years/65\, 74/g" AdultBMI.csv
sed -i "s/65 years and over/65\, 100/g" AdultBMI.csv
sed -i "s/75 years and over/75\, 100/g" AdultBMI.csv
sed -i "s/\"Total, 12 years and over\"/12\, 100/g" AdultBMI.csv
sed -i "s/Males/M/g" AdultBMI.csv
sed -i "s/Females/F/g" AdultBMI.csv
sed -i "s/Both sexes/B/g" AdultBMI.csv
sed -i "s/\"Total, 20-64 years\"/12\, 64/g" AdultBMI.csv

