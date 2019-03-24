import React from 'react'
import { Route, Link } from 'react-router-dom'
import Settings from './Pages/Settings'
import Details from './Pages/Details'
import User from './Pages/User'
import CreateNewEpisode from './Pages/CreateNewEpisode'

const App = () => (
  <div>
    <header>
      <Link to="">Home</Link>
      <Link to="/dashboard/details">Podcast Details</Link>
      <Link to="/dashboard/settings">Settings</Link>
      <Link to="/dashboard/user">User Management</Link>
    </header>

    <main>
      <Route exact path="/dashboard/settings" component={Settings} />
      <Route exact path="/dashboard/user" component={User} />
      <Route exact path="/dashboard/details" component={Details} />
      <Route exact path="/dashboard/create-episode" component={CreateNewEpisode} />
    </main>
  </div>
);

export default App
