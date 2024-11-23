import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";

function Home() {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    // gets all events from php app
    const fetchData = async () => {
      const response = await fetch("http://civic.local/events");
      const data = await response.json();
      if (data.success) {
        setEvents(data.items);
      }

      return data;
    };

    try {
      fetchData();
    } catch (e) {
      console.error(e);
    }
  }, []);

  return (
    <>
      <h2>List of all events</h2>
      <table className="table">
        <thead>
          <tr>
            <th scope="col" width="10%">
              #
            </th>
            <th scope="col" width="20%">
              Event name
            </th>
            <th scope="col" width="70%">
              &nbsp;
            </th>
          </tr>
        </thead>
        <tbody>
          {(events.length === 0 && "Loading events...") ||
            events.map((event, index) => (
              <tr key={event.id}>
                <th scope="row">{index + 1}</th>
                <td>{event.title}</td>
                <td>
                  <Link
                    className="nav-link underline"
                    to={`event-details/${event.id}`}
                  >
                    View event details
                  </Link>
                </td>
              </tr>
            ))}
        </tbody>
      </table>

      <Link to="/add-event" className="btn btn-primary">
        Add Event
      </Link>
    </>
  );
}

export default Home;
