import cv2
import imutils
import numpy as np
import pytesseract
from datetime import datetime
import csv
import MySQLdb

pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"

filename = "listcars.csv"
f = open(filename, "wt")
f.close()

cap = cv2.VideoCapture(0)

while True:
    ret, frame = cap.read()

    img = cv2.resize(frame, (620, 480))
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)  # convert to grey scale
    bfilter = cv2.bilateralFilter(gray, 11, 17, 17)  # Blur to reduce noise
    edged = cv2.Canny(bfilter, 10, 200)  # Perform Edge detection

    # find contours in the edged image, keep only the largest
    # ones, and initialize our screen contour
    keypoints = cv2.findContours(edged.copy(), cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
    cnts = imutils.grab_contours(keypoints)
    cnts = sorted(cnts, key=cv2.contourArea, reverse=True)[:10]

    screenCnt = None

    # loop over our contours
    for c in cnts:
        # approximate the contour
        approx = cv2.approxPolyDP(c, 15, True)

        # if our approximated contour has four points, then
        # we can assume that we have found our screen
        if len(approx) == 4:
            screenCnt = approx
            break

    if screenCnt is None:
        detected = 0
        print("No contour detected")
    else:
        detected = 1

    if detected == 1:
        cv2.drawContours(img, [screenCnt], -1, (0, 255, 0), 3)
        # Masking the part other than the number plate
        mask = np.zeros(gray.shape, np.uint8)
        new_image = cv2.drawContours(mask, [screenCnt], 0, 255, -1)
        new_image = cv2.bitwise_and(img, img, new_image, mask=mask)

        # Now crop
        (x, y) = np.where(mask == 255)
        (topx, topy) = (np.min(x), np.min(y))
        (bottomx, bottomy) = (np.max(x), np.max(y))
        Cropped = gray[topx:bottomx + 1, topy:bottomy + 1]

        # Read the number plate
        # text = pytesseract.image_to_string(Cropped, config='--psm 11')
        # print("License Plate is:", text)
        read = pytesseract.image_to_string(Cropped)
        read = ''.join(e for e in read if e.isalnum())
        print(read)

        with open('listcars.csv', 'r+') as f:
            myDatalist = f.readlines()
            numlist = []
            for line in myDatalist:
                entry = line.split(',')
                numlist.append(entry[0])
            if read not in numlist:
                now = datetime.now()
                # dtString = now.strftime('%H:%M:%S')
                f.writelines(f'{read},{now.strftime("%Y-%m-%d %H:%M:%S")}')
                f.writelines('\n')

        cv2.imshow('Cropped', Cropped)
        cv2.imshow('License Plate', img)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

myDB = MySQLdb.connect(host="127.0.0.1", user="root", database="db2")
with open('listcars.csv') as csv_file:
    csvfile = csv.reader(csv_file, delimiter=',')
    all_value = []
    for row in csvfile:
        value = (row[0], row[1]) #appending values to sql table
        all_value.append(value)

query = "insert into `#your_table_name_here`(`col_1`, `col2`) values (%s,%s)" #example of sql table creation
mycursor = myDB.cursor()
mycursor.executemany(query, all_value)
myDB.commit()

cap.release()
cv2.destroyAllWindows()
