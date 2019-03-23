import React from 'react'
import PropTypes from "prop-types";

class SettingsForm extends React.Component {
  constructor (props) {
    super(props)

    this.state = {
      isChecked: false,
      name: '',
      id: '',
      type: ''
    }
  }

    handleCheck = (e) => {
      let isChecked = e.target.checked
      this.setState({ isChecked: isChecked })
      this.props.handleUpdate(this.state.id, isChecked)
    };

    handleChange = (e) => {
      let isChecked = e.target.value
      this.setState({ isChecked: isChecked })
      this.props.handleUpdate(this.state.id, isChecked)
    };

    componentDidMount () {
      let { setting } = this.props

      this.setState({
        isChecked: setting.value, name: setting.name, id: setting.id, type: setting.type
      })
    }

    render () {
      let input = <input type='checkbox' defaultChecked={this.state.isChecked} onChange={this.handleCheck}/>

      if (this.state.type === 'text') {
        input = <input type='text'
          value={this.isChecked}
          onChange={this.handleChange}
        />
      }

      return (
        <div>
          <form>
            <label>{this.state.name}</label>
            {input}
          </form>
        </div>
      )
    }
}

SettingsForm.propTypes = {
  handleUpdate: PropTypes.func,
  setting: PropTypes.object
};

export default SettingsForm
