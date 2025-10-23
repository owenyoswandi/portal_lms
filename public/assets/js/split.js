const fs = require('fs');

const jsonData = require('./kelurahans.json');

const groupedData = jsonData.reduce((result, item) => {
  const keccode = item.keccode;

  if (!result[keccode]) {
    result[keccode] = [];
  }

  result[keccode].push(item);
  return result;
}, {});

// Convert the grouped data to an array (if needed)
// const groupedArray = Object.values(groupedData);

Object.entries(groupedData).forEach(([keccode, group]) => {
    const fileName = `output_${keccode}.json`;
    const jsonData = JSON.stringify(group, null, 2);
  
    fs.writeFileSync(fileName, jsonData);
    console.log(`File "${fileName}" created successfully.`);
  });
