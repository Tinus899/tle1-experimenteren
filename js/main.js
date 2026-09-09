async function fetchAnimals(lat, lng, distance) {
  if (lat && lng) {
    console.log("fetching animals with lat and lng", lat, lng);
    return await fetch("/api/animals", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify({ lat, lng, distance }),
    })
      .then((res) => res.json())
      .catch((err) => console.error(err));
  }

  return await fetch("/api/animals", {
    method: "GET",
  })
    .then((res) => res.json())
    .catch((err) => console.error(err));
}
