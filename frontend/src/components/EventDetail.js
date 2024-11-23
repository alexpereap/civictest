import React, { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";

function EventDetail() {
  const { id } = useParams();
  const [event, setEvent] = useState({});

  // gets event details from php app
  useEffect(() => {
    const fetchData = async () => {
      const response = await fetch("http://civic.local/events/" + id);
      const data = await response.json();
      if (data.success) {
        setEvent(data);
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
      <h1>Event details</h1>
      <Link className="nav-link underline" to="/">
        {"<<"} Go back
      </Link>
      {(Object.keys(event).length === 0 && "Loading event details...") || (
        <table className="table">
          <thead>
            <tr>
              <th scope="col" width="10%">
                &nbsp;
              </th>
              <th scope="col" width="90%">
                &nbsp;
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <strong>ID</strong>
              </td>
              <td>{event.id}</td>
            </tr>
            <tr>
              <td>
                <strong>Title</strong>
              </td>
              <td>{event.title}</td>
            </tr>
            <tr>
              <td>
                <strong>Description</strong>
              </td>
              <td>{event.description}</td>
            </tr>
            <tr>
              <td>
                <strong>Start Date</strong>
              </td>
              <td>{event.startDate}</td>
            </tr>
            <tr>
              <td>
                <strong>End Date</strong>
              </td>
              <td>{event.endDate}</td>
            </tr>
          </tbody>
        </table>
      )}
    </>
  );
}

export default EventDetail;
