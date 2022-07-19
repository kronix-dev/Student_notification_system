import json
import sys
with open('../uploads/attachments/'+sys.argv[1]) as json_file:
    mp_data = json.load(json_file)
    xd_data = mp_data
    dx_data = mp_data["features"]
    attr_data = mp_data
    uniqid_val = sys.argv[2]
    # itera = iter()
    # del attr_data["features"]
    # print(mp_data["features"])
    attr = []
    for p in dx_data:
        valx= p["properties"][sys.argv[3]]
        if valx not in attr:
            attr.append(valx)
    for x in range(len(attr)):
        attribute=attr[x]
        zon=repr(attr[x]).replace("/","")
        filez = zon.replace(" ","_")
        filez = filez.replace("u'","")
        filez = filez.replace("'","")
        liq = []
        for data in dx_data:
            if attribute == data["properties"][sys.argv[3]]:
                liq.append(data)
        attr_data["features"]=liq
        with open("../uploads/attachments/"+uniqid_val+filez+".geojson", 'w') as outfile:
            json.dump(attr_data, outfile)
            attr_data=mp_data
    print (json.dumps(attr))
