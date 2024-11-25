import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";

function AddEvent() {
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [startDate, setStartDate] = useState("");
  const [endDate, setEndDate] = useState("");
  const [formDisabled, setFormDisabled] = useState(false);
  const navigate = useNavigate();

  function goBackHome() {
    return navigate("/");
  }

  async function handleSubmit(e) {
    e.preventDefault();
    if (endDate < startDate) {
      alert("Please make sure the end date is a date after the start date");
      return;
    }

    const payLoad = {
      title,
      description,
      startDate,
      endDate,
    };

    try {
      setFormDisabled(true);
      const response = await fetch("http://civic.local/event", {
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify(payLoad),
      });

      const data = await response.json();

      if (data.success) {
        goBackHome();
      } else {
        alert(`Something went wrong ${data?.error}`);
        setFormDisabled(false);
      }
    } catch (e) {
      console.error(e);
      setFormDisabled(false);
    }
  }

  return (
    <>
      <h1>Add event</h1>
      <Link className="nav-link underline" to="/">
        {"<<"} Go back
      </Link>
      <div>&nbsp;</div>
      <form onSubmit={handleSubmit} disabled={formDisabled && "disabled"}>
        <div className="form-group">
          <label htmlFor="title">Title</label>
          <input
            id="title"
            type="text"
            className="form-control"
            placeholder="Enter Title"
            required
            value={title}
            onChange={(e) => setTitle(e.target.value)}
          />
        </div>
        <div className="form-group">
          <label htmlFor="description">Description</label>
          <textarea
            id="description"
            className="form-control"
            placeholder="Enter Description"
            required
            value={description}
            onChange={(e) => setDescription(e.target.value)}
          />
        </div>
        <div className="form-group">
          <label htmlFor="startDate">Start Date</label>
          <input
            id="startDate"
            type="datetime-local"
            className="form-control"
            required
            value={startDate}
            onChange={(e) => setStartDate(e.target.value)}
          />
        </div>
        <div className="form-group">
          <label htmlFor="endDate">End Date</label>
          <input
            id="endDate"
            required
            type="datetime-local"
            className="form-control"
            value={endDate}
            onChange={(e) => setEndDate(e.target.value)}
          />
        </div>
        <button
          disabled={formDisabled && "disabled"}
          type="submit"
          className="btn btn-primary"
        >
          Submit
        </button>
      </form>
    </>
  );
}

export default AddEvent;
