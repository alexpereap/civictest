import React from "react";
import { Outlet, Link } from "react-router-dom";

function Header() {
  return (
    <>
      <header>
        <nav className="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
          <span className="navbar-brand">CivicPlus Test</span>
          <div className="collapse navbar-collapse" id="navbarCollapse">
            <ul className="navbar-nav mr-auto">
              <li className="nav-item active">
                <Link className="nav-link" to="/">
                  Home (view all events)
                </Link>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <main role="main" className="container">
        <Outlet />
      </main>
    </>
  );
}

export default Header;
