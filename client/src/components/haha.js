const data = [
  { id: 1, name: "N1", parent_id: null },
  { id: 2, name: "N2", parent_id: null },
  { id: 3, name: "N3", parent_id: 1 },
  { id: 4, name: "N4", parent_id: 1 },
  { id: 5, name: "N5", parent_id: 2 },
  { id: 6, name: "N6", parent_id: 4 },
];

function buildHierarchy(arr, parentId = null) {
  return arr
    .filter((item) => item.parent_id === parentId)
    .map((item) => {
      const children = buildHierarchy(arr, item.id);
      return children.length
        ? { name: item.name, children }
        : { name: item.name };
    });
}

const hierarchy = buildHierarchy(data);
console.log(JSON.stringify(hierarchy, null, 2));
