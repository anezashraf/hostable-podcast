import React from 'react'
import { bindActionCreators } from 'redux'
import { fetchSettings, updateSetting } from '../Reducers/setting'
import { Link } from 'react-router-dom'

import { connect } from 'react-redux'
import SettingsForm from '../Components/Forms/SettingsForm'
import PropTypes from "prop-types";

class Settings extends React.Component {
  componentDidMount () {
    this.props.fetchSettings()
  }

    handleUpdate = (id, value) => {
      this.props.updateSetting(id, value)
    };

    render () {
      let { settings } = this.props;

      return (
        <section>
          <Link to={'/dashboard/create-episode'}>Create New Episode</Link>
          {settings.map((value, index) => {
            return (<SettingsForm key={index} setting={value} handleUpdate={this.handleUpdate} />)
          })}
        </section>
      )
    }
}

Settings.propTypes = {
    fetchSettings: PropTypes.func,
    updateSettings: PropTypes.func,
    updateSetting: PropTypes.func,
    settings: PropTypes.array,
};

const mapStateToProps = ({ setting }) => ({
  settings: setting.settings
});

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchSettings,
      updateSetting
    },
    dispatch
  );

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Settings)