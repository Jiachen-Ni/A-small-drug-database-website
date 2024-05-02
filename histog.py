#!/usr/bin/python3
import sys
import pymysql
import numpy as np
import matplotlib.pyplot as plt
import io

# ???????
if len(sys.argv) != 4:
    print("Usage: histog.py <column> <name> <condition>; Nparams =", sys.argv)
    sys.exit(-1)

# ?????
con = pymysql.connect(host='127.0.0.1', user='s2441797', passwd='Njc0412.', db='s2441797_website')
cur = con.cursor()

# ??????????
col1, xname, col2 = sys.argv[1], sys.argv[2], sys.argv[3]

# ?????SQL??
sql = "SELECT %s FROM Compounds WHERE %s" % (col1, col2)
cur.execute(sql)
ds = cur.fetchall()

# ???????????
if not ds:
    print("No data found for the given query.")
    sys.exit(-1)

# ?????numpy??
ads = np.array(ds).astype(np.float).flatten()

# ????????????DPI
plt.figure(figsize=(7, 5), dpi=96)  # DPI???96

# ??'ggplot'??
plt.style.use('ggplot')

# ?????
num_bins = 20
n, bins, patches = plt.hist(ads, num_bins, density=False, facecolor='skyblue', alpha=0.7, edgecolor='black')

# ??????????
plt.title(f'Histogram of {xname}', fontsize=14)  # ??14pt
plt.xlabel(xname, fontsize=12)  # ?????12pt
plt.ylabel('Frequency', fontsize=12)  # ?????12pt

# ????????????
plt.xticks(fontsize=10.5)  # ?????10.5pt
plt.yticks(fontsize=10.5)  # ?????10.5pt

# ????
plt.grid(True, linestyle='--', linewidth=0.5)

# ??????PNG??
image = io.BytesIO()
plt.savefig(image, format='png')  # DPI???figure???

# ??????
sys.stdout.buffer.write(image.getvalue())

# ???????
con.close()
