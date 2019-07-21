result=$( sudo docker images )

if [[ -n "$result" ]]; then
  echo "Container exists"
else
  echo "No such container"
fi