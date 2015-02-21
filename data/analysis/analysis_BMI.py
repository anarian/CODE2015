__author__ = 'mattchan'


from pandas import read_csv
import numpy as np
import sys

# csv_data = read_csv(sys.argv[1])
csv_data = read_csv("data/analysis/smoking-01050027-eng.csv")
csv_data = csv_data.values
results = []

for i in csv_data:
    coords = [int(j) for j in i[-2].split(".")]
    results.append(coords)

a = np.array(results)

past0 = a[0, 2]
temp = []

# with open(sys.argv[2], "w") as fh:
with open("data/analysis/smoking-01050027-eng_san.csv", "w") as fh:
    for key, i in enumerate(csv_data):
        cur0 = a[key, 2]

        if cur0 != past0:
            # new coord in first 2
            msg = "\"{0}\",{1},{2},{3},{4},{5}\n".format(i[0], i[1], i[2], i[3], i[4], ",".join(map(str, temp)))
            # print msg
            fh.write(msg)
            temp = []

        if i[-1] == "F":
            temp.append(-1)
        elif i[-1] == "..":
            temp.append(-1)
        else:
            temp.append(i[-1])
        past0 = cur0

    msg = "\"{0}\",{1},{2},{3},{4},{5}\n".format(i[0], i[1], i[2], i[3], i[4], ",".join(map(str, temp)))
    # print msg
    fh.write(msg)
