import cv2
import numpy as np
import pandas as pd
import argparse
import mysql.connector
from mysql.connector import Error

# Creating argument parser to take image path from command line
ap = argparse.ArgumentParser()
ap.add_argument('-i', '--image', required=True, help="Image Path")
args = vars(ap.parse_args())
img_path = args['image']

# Reading the image with OpenCV
img = cv2.imread(img_path)

# Reading CSV file with pandas and giving names to each column
index=["color","color_name","hex","R","G","B"]
csv = pd.read_csv('D:/Freelance/skripsi/freepik/public/scripts/colors.csv', names=index, header=None)

# Function to calculate minimum distance from all colors and get the most matching color
def getColorName(R, G, B):
    minimum = 10000
    for i in range(len(csv)):
        d = abs(R - int(csv.loc[i, "R"])) + abs(G - int(csv.loc[i, "G"])) + abs(B - int(csv.loc[i, "B"]))
        if d <= minimum:
            minimum = d
            cname = csv.loc[i, "color_name"]
    return cname

# Resize the image to make it smaller for faster processing
img = cv2.resize(img, (600, 400))

# Convert image to a list of pixels
pixels = np.float32(img.reshape(-1, 3))

# Define criteria, number of clusters (K), and apply k-means
criteria = (cv2.TERM_CRITERIA_EPS + cv2.TERM_CRITERIA_MAX_ITER, 100, 0.2)
k = 5  # Number of clusters (you can change this value)
_, labels, centers = cv2.kmeans(pixels, k, None, criteria, 10, cv2.KMEANS_RANDOM_CENTERS)

# Convert centers to 8-bit values
centers = np.uint8(centers)

# Count the frequency of each cluster
counts = np.bincount(labels.flatten())

# Get the most dominant color
dominant = centers[np.argmax(counts)]

# Get the color name of the dominant color
dominant_color_name = getColorName(dominant[2], dominant[1], dominant[0])

# Display the result
# print(f"The most dominant color is: {dominant_color_name} (R={dominant[2]}, G={dominant[1]}, B={dominant[0]})")

print(dominant_color_name + '//' + str(dominant[2]) + ',' + str(dominant[1]) + ',' + str(dominant[0]))